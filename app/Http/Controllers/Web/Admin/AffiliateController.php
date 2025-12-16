<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('role', function ($q) {
            $q->where('name', 'affiliate');
        })->with(['enrollments', 'commissions']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $affiliates = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.affiliates.index', compact('affiliates'));
    }

    public function show(User $affiliate)
    {
        $affiliate->load(['enrollments.program', 'commissions', 'trackingLinks.events', 'payouts', 'paymentMethods']);

        // Calculate clicks and conversions from tracking events
        $totalClicks = 0;
        $totalConversions = 0;
        foreach ($affiliate->trackingLinks as $link) {
            $totalClicks += $link->events->where('event_type', 'click')->count();
            $totalConversions += $link->events->where('event_type', 'conversion')->count();
        }

        $stats = [
            'total_commissions' => $affiliate->commissions->sum('amount') ?? 0,
            'pending_commissions' => $affiliate->commissions->where('status', 'pending')->sum('amount') ?? 0,
            'approved_commissions' => $affiliate->commissions->where('status', 'approved')->sum('amount') ?? 0,
            'total_clicks' => $totalClicks,
            'total_conversions' => $totalConversions,
            'active_programs' => $affiliate->enrollments->where('status', 'approved')->count(),
        ];

        return view('admin.affiliates.show', compact('affiliate', 'stats'));
    }

    public function edit(User $affiliate)
    {
        return view('admin.affiliates.edit', compact('affiliate'));
    }

    public function update(Request $request, User $affiliate)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $affiliate->id],
            'is_active' => ['nullable'],
        ]);

        $affiliate->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate updated successfully.');
    }

    public function toggleStatus(User $affiliate)
    {
        $affiliate->update(['is_active' => !$affiliate->is_active]);

        return back()->with('success', 'Affiliate status updated successfully.');
    }

    public function destroy(User $affiliate)
    {
        // Check if affiliate has any commissions or payouts
        if ($affiliate->commissions()->exists() || $affiliate->payouts()->exists()) {
            return back()->with('error', 'Cannot delete affiliate with existing commissions or payouts.');
        }

        $affiliate->enrollments()->delete();
        $affiliate->trackingLinks()->delete();
        $affiliate->delete();

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate deleted successfully.');
    }

    public function resetPassword(Request $request, User $affiliate)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $affiliate->update([
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('success', 'Password reset successfully.');
    }

    // Payment Method Management
    public function createPaymentMethod(User $affiliate)
    {
        return view('admin.affiliates.payment-methods.create', compact('affiliate'));
    }

    public function storePaymentMethod(Request $request, User $affiliate)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:bank,paypal,wise'],
            'is_active' => ['nullable'],
            'is_verified' => ['nullable'],
            // Bank fields
            'bank_name' => ['required_if:type,bank', 'nullable', 'string', 'max:255'],
            'account_number' => ['required_if:type,bank', 'nullable', 'string', 'max:255'],
            'account_name' => ['required_if:type,bank', 'nullable', 'string', 'max:255'],
            'routing_number' => ['nullable', 'string', 'max:255'],
            'swift_code' => ['nullable', 'string', 'max:255'],
            // PayPal/Wise fields
            'email' => ['required_if:type,paypal,wise', 'nullable', 'email', 'max:255'],
        ]);

        $details = $this->buildPaymentDetails($validated);

        $affiliate->paymentMethods()->create([
            'type' => $validated['type'],
            'details' => $details,
            'is_active' => $request->has('is_active'),
            'is_verified' => $request->has('is_verified'),
        ]);

        return redirect()->route('admin.affiliates.show', $affiliate)
            ->with('success', 'Payment method added successfully.');
    }

    public function editPaymentMethod(User $affiliate, PaymentMethod $paymentMethod)
    {
        return view('admin.affiliates.payment-methods.edit', compact('affiliate', 'paymentMethod'));
    }

    public function updatePaymentMethod(Request $request, User $affiliate, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:bank,paypal,wise'],
            'is_active' => ['nullable'],
            'is_verified' => ['nullable'],
            // Bank fields
            'bank_name' => ['required_if:type,bank', 'nullable', 'string', 'max:255'],
            'account_number' => ['required_if:type,bank', 'nullable', 'string', 'max:255'],
            'account_name' => ['required_if:type,bank', 'nullable', 'string', 'max:255'],
            'routing_number' => ['nullable', 'string', 'max:255'],
            'swift_code' => ['nullable', 'string', 'max:255'],
            // PayPal/Wise fields
            'email' => ['required_if:type,paypal,wise', 'nullable', 'email', 'max:255'],
        ]);

        $details = $this->buildPaymentDetails($validated);

        $paymentMethod->update([
            'type' => $validated['type'],
            'details' => $details,
            'is_active' => $request->has('is_active'),
            'is_verified' => $request->has('is_verified'),
        ]);

        return redirect()->route('admin.affiliates.show', $affiliate)
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroyPaymentMethod(User $affiliate, PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->payouts()->exists()) {
            return back()->with('error', 'Cannot delete payment method with existing payouts.');
        }

        $paymentMethod->delete();

        return redirect()->route('admin.affiliates.show', $affiliate)
            ->with('success', 'Payment method deleted successfully.');
    }

    private function buildPaymentDetails(array $validated): array
    {
        return match ($validated['type']) {
            'bank' => [
                'bank_name' => $validated['bank_name'] ?? '',
                'account_number' => $validated['account_number'] ?? '',
                'account_name' => $validated['account_name'] ?? '',
                'routing_number' => $validated['routing_number'] ?? '',
                'swift_code' => $validated['swift_code'] ?? '',
            ],
            'paypal', 'wise' => [
                'email' => $validated['email'] ?? '',
            ],
            default => [],
        };
    }
}
