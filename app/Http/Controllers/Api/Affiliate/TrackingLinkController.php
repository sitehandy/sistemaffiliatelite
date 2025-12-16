<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingLinkController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = TrackingLink::where('user_id', auth()->id())
            ->with(['enrollment.program', 'product']);

        if ($request->has('enrollment_id')) {
            $query->where('program_enrollment_id', $request->enrollment_id);
        }

        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $links = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($links);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'enrollment_id' => ['required', 'exists:program_enrollments,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'custom_params' => ['nullable', 'array'],
        ]);

        $enrollment = ProgramEnrollment::findOrFail($validated['enrollment_id']);

        if ($enrollment->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        if (!$enrollment->isApproved()) {
            return response()->json([
                'message' => 'You can only create tracking links for approved enrollments.',
            ], 422);
        }

        $trackingLink = TrackingLink::create([
            'user_id' => auth()->id(),
            'program_enrollment_id' => $enrollment->id,
            'product_id' => $validated['product_id'] ?? null,
            'code' => TrackingLink::generateUniqueCode(),
            'name' => $validated['name'] ?? null,
            'custom_params' => $validated['custom_params'] ?? null,
        ]);

        $trackingLink->load(['enrollment.program', 'product']);

        return response()->json([
            'message' => 'Tracking link created successfully.',
            'tracking_link' => $trackingLink,
            'full_url' => $trackingLink->getFullUrl(),
        ], 201);
    }

    public function show(TrackingLink $trackingLink): JsonResponse
    {
        if ($trackingLink->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $trackingLink->load(['enrollment.program', 'product', 'events', 'conversions']);

        return response()->json([
            'tracking_link' => $trackingLink,
            'full_url' => $trackingLink->getFullUrl(),
            'stats' => [
                'clicks' => $trackingLink->click_count,
                'conversions' => $trackingLink->conversion_count,
                'conversion_rate' => $trackingLink->click_count > 0
                    ? round(($trackingLink->conversion_count / $trackingLink->click_count) * 100, 2)
                    : 0,
            ],
        ]);
    }

    public function update(Request $request, TrackingLink $trackingLink): JsonResponse
    {
        if ($trackingLink->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'custom_params' => ['nullable', 'array'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $trackingLink->update($validated);

        return response()->json([
            'message' => 'Tracking link updated successfully.',
            'tracking_link' => $trackingLink->fresh(['enrollment.program', 'product']),
        ]);
    }

    public function destroy(TrackingLink $trackingLink): JsonResponse
    {
        if ($trackingLink->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        if ($trackingLink->conversions()->exists()) {
            return response()->json([
                'message' => 'Cannot delete tracking link with existing conversions.',
            ], 422);
        }

        $trackingLink->delete();

        return response()->json([
            'message' => 'Tracking link deleted successfully.',
        ]);
    }

    public function stats(TrackingLink $trackingLink): JsonResponse
    {
        if ($trackingLink->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $events = $trackingLink->events()
            ->selectRaw('DATE(created_at) as date, event_type, COUNT(*) as count')
            ->groupBy('date', 'event_type')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return response()->json([
            'tracking_link' => $trackingLink,
            'total_clicks' => $trackingLink->click_count,
            'total_conversions' => $trackingLink->conversion_count,
            'events_by_date' => $events,
        ]);
    }
}
