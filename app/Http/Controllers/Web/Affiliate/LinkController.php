<?php

namespace App\Http\Controllers\Web\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TrackingLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->trackingLinks()->with(['product', 'program']);

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('product', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $links = $query->withCount(['trackingEvents as clicks_count' => fn($q) => $q->where('event_type', 'click')])
            ->withCount('conversions')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get enrolled programs for filter
        $enrolledPrograms = auth()->user()->enrollments()
            ->where('status', 'approved')
            ->with('program')
            ->get()
            ->pluck('program');

        return view('affiliate.links.index', compact('links', 'enrolledPrograms'));
    }

    public function create()
    {
        // Get approved enrollments with their programs and products
        $enrollments = auth()->user()->enrollments()
            ->where('status', 'approved')
            ->with(['program.products' => fn($q) => $q->where('is_active', true)])
            ->get();

        return view('affiliate.links.create', compact('enrollments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:affiliate_programs,id'],
            'product_id' => ['nullable', 'exists:products,id'],
        ]);

        // Verify user is enrolled in the program
        $enrollment = auth()->user()->enrollments()
            ->where('program_id', $validated['program_id'])
            ->where('status', 'approved')
            ->with('program')
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'You are not enrolled in this program.');
        }

        $productId = $validated['product_id'] ?? null;

        // If product is selected, verify it's in the program
        if ($productId) {
            $product = Product::find($productId);
            if (!$product->programs()->where('affiliate_programs.id', $validated['program_id'])->exists()) {
                return back()->with('error', 'This product is not part of the selected program.');
            }
        } else {
            // If no product selected, ensure program has a default URL
            if (empty($enrollment->program->default_url)) {
                return back()->with('error', 'This program does not have a default landing page URL. Please select a product or ask admin to set a default URL.');
            }
        }

        // Check if link already exists
        $existingLink = TrackingLink::where('user_id', auth()->id())
            ->where('program_id', $validated['program_id'])
            ->where('product_id', $productId)
            ->first();

        if ($existingLink) {
            return back()->with('error', 'You already have a tracking link for this selection.');
        }

        // Create tracking link
        $link = TrackingLink::create([
            'user_id' => auth()->id(),
            'program_id' => $validated['program_id'],
            'product_id' => $productId,
            'unique_code' => $this->generateUniqueCode(),
        ]);

        return redirect()->route('affiliate.links.index')
            ->with('success', 'Tracking link created successfully.');
    }

    public function show(TrackingLink $link)
    {
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }

        $link->load(['product', 'program']);

        // Get statistics
        $stats = [
            'total_clicks' => $link->trackingEvents()->where('event_type', 'click')->count(),
            'unique_clicks' => $link->trackingEvents()->where('event_type', 'click')->distinct('ip_address')->count('ip_address'),
            'total_conversions' => $link->trackingEvents()->where('event_type', 'conversion')->count(),
            'total_earnings' => \App\Models\Commission::whereHas('conversion.trackingEvent', function ($q) use ($link) {
                $q->where('tracking_link_id', $link->id);
            })->sum('amount'),
        ];

        // Recent events
        $recentEvents = $link->trackingEvents()
            ->latest()
            ->take(20)
            ->get();

        return view('affiliate.links.show', compact('link', 'stats', 'recentEvents'));
    }

    public function destroy(TrackingLink $link)
    {
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }

        // Check for pending commissions
        $hasPendingCommissions = \App\Models\Commission::whereHas('conversion.trackingEvent', function ($q) use ($link) {
            $q->where('tracking_link_id', $link->id);
        })->where('status', 'pending')->exists();

        if ($hasPendingCommissions) {
            return back()->with('error', 'Cannot delete link with pending commissions.');
        }

        $link->delete();

        return redirect()->route('affiliate.links.index')
            ->with('success', 'Tracking link deleted successfully.');
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(8);
        } while (TrackingLink::where('unique_code', $code)->exists());

        return $code;
    }
}
