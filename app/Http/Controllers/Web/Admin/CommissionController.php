<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::with(['user', 'conversion.trackingEvent.trackingLink.program']);

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

        $commissions = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'pending_total' => Commission::pending()->sum('amount'),
            'approved_total' => Commission::approved()->sum('amount'),
            'paid_total' => Commission::paid()->sum('amount'),
        ];

        return view('admin.commissions.index', compact('commissions', 'stats'));
    }

    public function show(Commission $commission)
    {
        $commission->load(['user', 'conversion.trackingEvent.trackingLink.program', 'conversion.trackingEvent.trackingLink.product']);
        return view('admin.commissions.show', compact('commission'));
    }

    public function approve(Commission $commission)
    {
        if (!$commission->isPending()) {
            return back()->with('error', 'Only pending commissions can be approved.');
        }

        $commission->approve();

        return back()->with('success', 'Commission approved successfully.');
    }

    public function reject(Commission $commission)
    {
        if (!$commission->isPending()) {
            return back()->with('error', 'Only pending commissions can be rejected.');
        }

        $commission->cancel();

        return back()->with('success', 'Commission rejected successfully.');
    }

    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'commission_ids' => ['required', 'array'],
            'commission_ids.*' => ['exists:commissions,id'],
        ]);

        $count = 0;
        foreach ($validated['commission_ids'] as $id) {
            $commission = Commission::find($id);
            if ($commission && $commission->isPending()) {
                $commission->approve();
                $count++;
            }
        }

        return back()->with('success', "{$count} commissions approved successfully.");
    }
}
