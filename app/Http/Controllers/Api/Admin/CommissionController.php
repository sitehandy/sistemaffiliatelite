<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Commission::with(['user', 'conversion.trackingLink.enrollment.program']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $commissions = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($commissions);
    }

    public function show(Commission $commission): JsonResponse
    {
        $commission->load(['user', 'conversion.trackingLink.enrollment.program']);

        return response()->json($commission);
    }

    public function approve(Commission $commission): JsonResponse
    {
        if (!$commission->isPending()) {
            return response()->json([
                'message' => 'Only pending commissions can be approved.',
            ], 422);
        }

        $commission->approve();

        // Also update the associated conversion status
        if ($commission->conversion) {
            $commission->conversion->update(['status' => 'approved']);
        }

        return response()->json([
            'message' => 'Commission approved successfully.',
            'commission' => $commission->fresh(['user', 'conversion']),
        ]);
    }

    public function reject(Request $request, Commission $commission): JsonResponse
    {
        if (!$commission->isPending()) {
            return response()->json([
                'message' => 'Only pending commissions can be rejected.',
            ], 422);
        }

        $commission->cancel();

        // Also update the associated conversion status
        if ($commission->conversion) {
            $commission->conversion->update(['status' => 'rejected']);
        }

        return response()->json([
            'message' => 'Commission rejected successfully.',
            'commission' => $commission->fresh(['user', 'conversion']),
        ]);
    }

    public function bulkApprove(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'commission_ids' => ['required', 'array'],
            'commission_ids.*' => ['exists:commissions,id'],
        ]);

        $count = Commission::whereIn('id', $validated['commission_ids'])
            ->where('status', 'pending')
            ->update(['status' => 'approved']);

        return response()->json([
            'message' => "{$count} commissions approved successfully.",
        ]);
    }

    public function stats(): JsonResponse
    {
        $pending = Commission::pending()->sum('amount');
        $approved = Commission::approved()->sum('amount');
        $paid = Commission::paid()->sum('amount');

        $pendingCount = Commission::pending()->count();
        $approvedCount = Commission::approved()->count();
        $paidCount = Commission::paid()->count();

        return response()->json([
            'amounts' => [
                'pending' => number_format($pending, 2),
                'approved' => number_format($approved, 2),
                'paid' => number_format($paid, 2),
                'total' => number_format($pending + $approved + $paid, 2),
            ],
            'counts' => [
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'paid' => $paidCount,
            ],
        ]);
    }
}
