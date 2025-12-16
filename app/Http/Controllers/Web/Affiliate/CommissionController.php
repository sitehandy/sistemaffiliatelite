<?php

namespace App\Http\Controllers\Web\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::where('user_id', auth()->id())
            ->with(['conversion.trackingEvent.trackingLink.program', 'conversion.trackingEvent.trackingLink.product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $commissions = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'pending_total' => Commission::where('user_id', auth()->id())->pending()->sum('amount'),
            'approved_total' => Commission::where('user_id', auth()->id())->approved()->sum('amount'),
            'paid_total' => Commission::where('user_id', auth()->id())->paid()->sum('amount'),
        ];

        return view('affiliate.commissions.index', compact('commissions', 'stats'));
    }

    public function show(Commission $commission)
    {
        if ($commission->user_id !== auth()->id()) {
            abort(403);
        }

        $commission->load(['conversion.trackingEvent.trackingLink.program', 'conversion.trackingEvent.trackingLink.product']);

        return view('affiliate.commissions.show', compact('commission'));
    }
}
