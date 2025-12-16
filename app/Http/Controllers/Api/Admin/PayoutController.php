<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Payout::with(['user', 'paymentMethod']);

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

        $payouts = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($payouts);
    }

    public function show(Payout $payout): JsonResponse
    {
        $payout->load(['user', 'paymentMethod']);

        $commissions = $payout->commissions()->get();

        return response()->json([
            'payout' => $payout,
            'commissions' => $commissions,
        ]);
    }

    public function process(Payout $payout): JsonResponse
    {
        if (!$payout->isPending()) {
            return response()->json([
                'message' => 'Only pending payouts can be processed.',
            ], 422);
        }

        $payout->startProcessing();

        return response()->json([
            'message' => 'Payout processing started.',
            'payout' => $payout->fresh(['user', 'paymentMethod']),
        ]);
    }

    public function complete(Request $request, Payout $payout): JsonResponse
    {
        if (!$payout->isProcessing()) {
            return response()->json([
                'message' => 'Only processing payouts can be completed.',
            ], 422);
        }

        $validated = $request->validate([
            'transaction_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $payout->complete($validated['transaction_reference'] ?? null);

        return response()->json([
            'message' => 'Payout completed successfully.',
            'payout' => $payout->fresh(['user', 'paymentMethod']),
        ]);
    }

    public function fail(Request $request, Payout $payout): JsonResponse
    {
        if (!$payout->isPending() && !$payout->isProcessing()) {
            return response()->json([
                'message' => 'Only pending or processing payouts can be marked as failed.',
            ], 422);
        }

        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $payout->fail($validated['notes'] ?? null);

        return response()->json([
            'message' => 'Payout marked as failed.',
            'payout' => $payout->fresh(['user', 'paymentMethod']),
        ]);
    }

    public function stats(): JsonResponse
    {
        $pending = Payout::pending()->sum('total_amount');
        $processing = Payout::processing()->sum('total_amount');
        $completed = Payout::completed()->sum('total_amount');

        $pendingCount = Payout::pending()->count();
        $processingCount = Payout::processing()->count();
        $completedCount = Payout::completed()->count();

        return response()->json([
            'amounts' => [
                'pending' => number_format($pending, 2),
                'processing' => number_format($processing, 2),
                'completed' => number_format($completed, 2),
            ],
            'counts' => [
                'pending' => $pendingCount,
                'processing' => $processingCount,
                'completed' => $completedCount,
            ],
        ]);
    }
}
