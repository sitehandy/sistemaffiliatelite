<?php

namespace App\Http\Controllers\Web\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Payout;
use App\Models\PaymentMethod;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        $query = Payout::where('user_id', auth()->id())
            ->with('paymentMethod');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payouts = $query->orderBy('created_at', 'desc')->paginate(15);

        // Available balance
        $availableBalance = Commission::where('user_id', auth()->id())
            ->approved()
            ->sum('amount');

        // Minimum payout amount
        $minPayoutAmount = SystemSetting::getValue('min_payout_amount', 50);

        // Payment methods
        $paymentMethods = auth()->user()->paymentMethods()->where('is_active', true)->get();

        return view('affiliate.payouts.index', compact('payouts', 'availableBalance', 'minPayoutAmount', 'paymentMethods'));
    }

    public function request(Request $request)
    {
        $validated = $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Verify payment method belongs to user
        $paymentMethod = PaymentMethod::where('id', $validated['payment_method_id'])
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->first();

        if (!$paymentMethod) {
            return back()->with('error', 'Invalid payment method.');
        }

        // Calculate available balance
        $availableBalance = Commission::where('user_id', auth()->id())
            ->approved()
            ->sum('amount');

        // Get minimum payout amount
        $minPayoutAmount = SystemSetting::getValue('min_payout_amount', 50);

        if ($availableBalance < $minPayoutAmount) {
            return back()->with('error', "Minimum payout amount is \${$minPayoutAmount}. Your available balance is \${$availableBalance}.");
        }

        // Determine payout amount
        $amount = $validated['amount'] ?? $availableBalance;
        if ($amount > $availableBalance) {
            return back()->with('error', 'Requested amount exceeds available balance.');
        }

        if ($amount < $minPayoutAmount) {
            return back()->with('error', "Minimum payout amount is \${$minPayoutAmount}.");
        }

        // Get commissions to include in payout
        $commissions = Commission::where('user_id', auth()->id())
            ->approved()
            ->orderBy('created_at')
            ->get();

        $commissionIds = [];
        $runningTotal = 0;

        foreach ($commissions as $commission) {
            if ($runningTotal >= $amount) {
                break;
            }
            $commissionIds[] = $commission->id;
            $runningTotal += $commission->amount;
        }

        // Create payout
        $payout = Payout::create([
            'user_id' => auth()->id(),
            'payment_method_id' => $paymentMethod->id,
            'total_amount' => $runningTotal,
            'commission_ids' => $commissionIds,
            'status' => 'pending',
        ]);

        // Mark commissions as included in payout
        Commission::whereIn('id', $commissionIds)->update(['payout_id' => $payout->id]);

        return redirect()->route('affiliate.payouts.index')
            ->with('success', 'Payout request submitted successfully.');
    }

    public function show(Payout $payout)
    {
        if ($payout->user_id !== auth()->id()) {
            abort(403);
        }

        $payout->load(['paymentMethod', 'commissions']);

        return view('affiliate.payouts.show', compact('payout'));
    }

    public function cancel(Payout $payout)
    {
        if ($payout->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$payout->isPending()) {
            return back()->with('error', 'Only pending payouts can be cancelled.');
        }

        // Release commissions
        Commission::whereIn('id', $payout->commission_ids ?? [])->update(['payout_id' => null]);

        $payout->cancel();

        return back()->with('success', 'Payout request cancelled.');
    }

    // Payment Methods Management
    public function paymentMethods()
    {
        $paymentMethods = auth()->user()->paymentMethods()->get();

        return view('affiliate.payouts.payment-methods', compact('paymentMethods'));
    }

    public function storePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:bank,paypal,wise'],
            'details' => ['required', 'array'],
        ]);

        // Validate details based on type
        $detailsRules = match ($validated['type']) {
            'bank' => [
                'details.bank_name' => ['required', 'string'],
                'details.account_name' => ['required', 'string'],
                'details.account_number' => ['required', 'string'],
                'details.routing_number' => ['nullable', 'string'],
                'details.swift_code' => ['nullable', 'string'],
            ],
            'paypal' => [
                'details.email' => ['required', 'email'],
            ],
            'wise' => [
                'details.email' => ['required', 'email'],
            ],
        };

        $request->validate($detailsRules);

        PaymentMethod::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'details' => $validated['details'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Payment method added successfully.');
    }

    public function updatePaymentMethod(Request $request, PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'details' => ['required', 'array'],
            'is_active' => ['boolean'],
        ]);

        $paymentMethod->update([
            'details' => $validated['details'],
            'is_active' => $validated['is_active'] ?? $paymentMethod->is_active,
        ]);

        return back()->with('success', 'Payment method updated successfully.');
    }

    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if used in pending payouts
        $hasPendingPayouts = Payout::where('payment_method_id', $paymentMethod->id)
            ->whereIn('status', ['pending', 'processing'])
            ->exists();

        if ($hasPendingPayouts) {
            return back()->with('error', 'Cannot delete payment method with pending payouts.');
        }

        $paymentMethod->delete();

        return back()->with('success', 'Payment method deleted successfully.');
    }
}
