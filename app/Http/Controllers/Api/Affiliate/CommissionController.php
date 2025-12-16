<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Commission::where('user_id', auth()->id())
            ->with(['conversion.trackingLink.enrollment.program', 'conversion.trackingLink.product']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $commissions = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        // Summary stats
        $totals = Commission::where('user_id', auth()->id())
            ->selectRaw('status, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return response()->json([
            'commissions' => $commissions,
            'summary' => [
                'pending' => [
                    'amount' => number_format($totals->get('pending')?->total ?? 0, 2),
                    'count' => $totals->get('pending')?->count ?? 0,
                ],
                'approved' => [
                    'amount' => number_format($totals->get('approved')?->total ?? 0, 2),
                    'count' => $totals->get('approved')?->count ?? 0,
                ],
                'paid' => [
                    'amount' => number_format($totals->get('paid')?->total ?? 0, 2),
                    'count' => $totals->get('paid')?->count ?? 0,
                ],
            ],
        ]);
    }

    public function show(Commission $commission): JsonResponse
    {
        if ($commission->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $commission->load(['conversion.trackingLink.enrollment.program', 'conversion.trackingLink.product']);

        return response()->json($commission);
    }
}
