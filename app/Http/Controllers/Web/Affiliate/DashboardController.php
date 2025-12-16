<?php

namespace App\Http\Controllers\Web\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Commission;
use App\Models\Conversion;
use App\Models\Payout;
use App\Models\TrackingEvent;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get statistics
        $stats = [
            'total_clicks' => TrackingEvent::whereHas('trackingLink', fn($q) => $q->where('user_id', $user->id))
                ->where('event_type', 'click')
                ->count(),
            'total_conversions' => Conversion::whereHas('trackingEvent.trackingLink', fn($q) => $q->where('user_id', $user->id))
                ->count(),
            'pending_commissions' => Commission::where('user_id', $user->id)->pending()->sum('amount'),
            'approved_commissions' => Commission::where('user_id', $user->id)->approved()->sum('amount'),
            'total_earnings' => Commission::where('user_id', $user->id)->whereIn('status', ['approved', 'paid'])->sum('amount'),
            'total_paid' => Payout::where('user_id', $user->id)->completed()->sum('total_amount'),
            'available_balance' => Commission::where('user_id', $user->id)->approved()->sum('amount'),
        ];

        // Recent commissions
        $recentCommissions = Commission::with(['conversion.trackingEvent.trackingLink.program'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Monthly earnings for chart
        $monthlyEarnings = $this->getMonthlyEarnings($user->id);

        // Active programs
        $activePrograms = $user->enrollments()
            ->where('status', 'approved')
            ->with('program')
            ->get()
            ->pluck('program');

        // Get active announcements
        $announcements = Announcement::active()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('affiliate.dashboard', compact(
            'stats',
            'recentCommissions',
            'monthlyEarnings',
            'activePrograms',
            'announcements'
        ));
    }

    private function getMonthlyEarnings(int $userId): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $earnings = Commission::where('user_id', $userId)
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return [
            'labels' => $months->map(fn($m) => date('M Y', strtotime($m . '-01')))->toArray(),
            'data' => $months->map(fn($m) => (float) ($earnings[$m] ?? 0))->toArray(),
        ];
    }
}
