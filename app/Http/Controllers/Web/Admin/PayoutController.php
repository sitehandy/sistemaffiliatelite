<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        $query = Payout::with(['user', 'paymentMethod']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payouts = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'pending_total' => Payout::pending()->sum('total_amount'),
            'processing_total' => Payout::processing()->sum('total_amount'),
            'completed_total' => Payout::completed()->sum('total_amount'),
        ];

        return view('admin.payouts.index', compact('payouts', 'stats'));
    }

    public function show(Payout $payout)
    {
        $payout->load(['user', 'paymentMethod', 'commissions']);
        return view('admin.payouts.show', compact('payout'));
    }

    public function process(Payout $payout)
    {
        if (!$payout->isPending()) {
            return back()->with('error', 'Only pending payouts can be processed.');
        }

        $payout->process();

        return back()->with('success', 'Payout is now being processed.');
    }

    public function complete(Request $request, Payout $payout)
    {
        if (!$payout->isProcessing()) {
            return back()->with('error', 'Only processing payouts can be completed.');
        }

        $validated = $request->validate([
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $payout->complete($validated['transaction_id'] ?? null, $validated['notes'] ?? null);

        return back()->with('success', 'Payout completed successfully.');
    }

    public function fail(Request $request, Payout $payout)
    {
        if (!$payout->isProcessing()) {
            return back()->with('error', 'Only processing payouts can be marked as failed.');
        }

        $validated = $request->validate([
            'reason' => ['required', 'string'],
        ]);

        $payout->fail($validated['reason']);

        return back()->with('success', 'Payout marked as failed.');
    }

    public function cancel(Payout $payout)
    {
        if (!$payout->isPending()) {
            return back()->with('error', 'Only pending payouts can be cancelled.');
        }

        $payout->cancel();

        return back()->with('success', 'Payout cancelled successfully.');
    }
}
