<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\PaymentMethod;
use App\Models\Payout;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Payout::where('user_id', auth()->id())
            ->with('paymentMethod');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $payouts = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($payouts);
    }

    public function show(Payout $payout): JsonResponse
    {
        if ($payout->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $payout->load('paymentMethod');
        $commissions = $payout->commissions()->get();

        return response()->json([
            'payout' => $payout,
            'commissions' => $commissions,
        ]);
    }

    public function request(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'commission_ids' => ['nullable', 'array'],
            'commission_ids.*' => ['exists:commissions,id'],
        ]);

        // Verify payment method belongs to user
        $paymentMethod = PaymentMethod::where('id', $validated['payment_method_id'])
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->first();

        if (!$paymentMethod) {
            return response()->json([
                'message' => 'Invalid or inactive payment method.',
            ], 422);
        }

        // Get approved commissions
        $commissionsQuery = Commission::where('user_id', auth()->id())
            ->where('status', 'approved');

        if (!empty($validated['commission_ids'])) {
            $commissionsQuery->whereIn('id', $validated['commission_ids']);
        }

        $commissions = $commissionsQuery->get();

        if ($commissions->isEmpty()) {
            return response()->json([
                'message' => 'No approved commissions available for payout.',
            ], 422);
        }

        $totalAmount = $commissions->sum('amount');

        // Check minimum payout threshold
        $minPayout = SystemSetting::get('min_payout_amount', 50);
        if ($totalAmount < $minPayout) {
            return response()->json([
                'message' => "Minimum payout amount is {$minPayout}. Your available balance is {$totalAmount}.",
            ], 422);
        }

        // Create payout request
        $payout = Payout::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'commission_ids' => $commissions->pluck('id')->toArray(),
            'payment_method_id' => $paymentMethod->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payout request submitted successfully.',
            'payout' => $payout->load('paymentMethod'),
        ], 201);
    }

    public function paymentMethods(): JsonResponse
    {
        $methods = PaymentMethod::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($method) {
                return [
                    'id' => $method->id,
                    'type' => $method->type,
                    'details' => $method->masked_details,
                    'is_active' => $method->is_active,
                    'is_verified' => $method->is_verified,
                    'created_at' => $method->created_at,
                ];
            });

        return response()->json($methods);
    }

    public function storePaymentMethod(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:bank,paypal,wise'],
            'details' => ['required', 'array'],
        ]);

        // Validate details based on type
        $detailsRules = match ($validated['type']) {
            'bank' => [
                'details.bank_name' => ['required', 'string', 'max:255'],
                'details.account_number' => ['required', 'string', 'max:50'],
                'details.account_holder' => ['required', 'string', 'max:255'],
                'details.routing_number' => ['nullable', 'string', 'max:50'],
            ],
            'paypal', 'wise' => [
                'details.email' => ['required', 'email', 'max:255'],
            ],
        };

        $request->validate($detailsRules);

        $paymentMethod = PaymentMethod::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'details' => $validated['details'],
            'is_active' => true,
            'is_verified' => false,
        ]);

        return response()->json([
            'message' => 'Payment method added successfully.',
            'payment_method' => [
                'id' => $paymentMethod->id,
                'type' => $paymentMethod->type,
                'details' => $paymentMethod->masked_details,
                'is_active' => $paymentMethod->is_active,
                'is_verified' => $paymentMethod->is_verified,
            ],
        ], 201);
    }

    public function updatePaymentMethod(Request $request, PaymentMethod $paymentMethod): JsonResponse
    {
        if ($paymentMethod->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'is_active' => ['sometimes', 'boolean'],
            'details' => ['sometimes', 'array'],
        ]);

        if (isset($validated['details'])) {
            $detailsRules = match ($paymentMethod->type) {
                'bank' => [
                    'details.bank_name' => ['sometimes', 'string', 'max:255'],
                    'details.account_number' => ['sometimes', 'string', 'max:50'],
                    'details.account_holder' => ['sometimes', 'string', 'max:255'],
                    'details.routing_number' => ['nullable', 'string', 'max:50'],
                ],
                'paypal', 'wise' => [
                    'details.email' => ['sometimes', 'email', 'max:255'],
                ],
                default => [],
            };

            $request->validate($detailsRules);

            $currentDetails = $paymentMethod->details ?? [];
            $validated['details'] = array_merge($currentDetails, $validated['details']);
        }

        $paymentMethod->update($validated);

        return response()->json([
            'message' => 'Payment method updated successfully.',
            'payment_method' => [
                'id' => $paymentMethod->id,
                'type' => $paymentMethod->type,
                'details' => $paymentMethod->masked_details,
                'is_active' => $paymentMethod->is_active,
                'is_verified' => $paymentMethod->is_verified,
            ],
        ]);
    }

    public function deletePaymentMethod(PaymentMethod $paymentMethod): JsonResponse
    {
        if ($paymentMethod->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($paymentMethod->payouts()->whereIn('status', ['pending', 'processing'])->exists()) {
            return response()->json([
                'message' => 'Cannot delete payment method with pending payouts.',
            ], 422);
        }

        $paymentMethod->delete();

        return response()->json([
            'message' => 'Payment method deleted successfully.',
        ]);
    }
}
