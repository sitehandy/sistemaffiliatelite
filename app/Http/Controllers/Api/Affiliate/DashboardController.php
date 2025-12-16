<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Conversion;
use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = auth()->id();

        $enrollments = ProgramEnrollment::where('user_id', $userId)
            ->where('status', 'approved')
            ->count();

        $totalClicks = TrackingLink::where('user_id', $userId)->sum('click_count');
        $totalConversions = TrackingLink::where('user_id', $userId)->sum('conversion_count');

        $pendingCommissions = Commission::where('user_id', $userId)
            ->where('status', 'pending')
            ->sum('amount');

        $approvedCommissions = Commission::where('user_id', $userId)
            ->where('status', 'approved')
            ->sum('amount');

        $paidCommissions = Commission::where('user_id', $userId)
            ->where('status', 'paid')
            ->sum('amount');

        $recentConversions = Conversion::whereHas('trackingLink', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['trackingLink.enrollment.program', 'trackingLink.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $topLinks = TrackingLink::where('user_id', $userId)
            ->where('click_count', '>', 0)
            ->with(['enrollment.program', 'product'])
            ->orderBy('click_count', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'stats' => [
                'active_enrollments' => $enrollments,
                'total_clicks' => (int) $totalClicks,
                'total_conversions' => (int) $totalConversions,
                'conversion_rate' => $totalClicks > 0
                    ? round(($totalConversions / $totalClicks) * 100, 2)
                    : 0,
            ],
            'earnings' => [
                'pending' => number_format($pendingCommissions, 2),
                'approved' => number_format($approvedCommissions, 2),
                'paid' => number_format($paidCommissions, 2),
                'total' => number_format($pendingCommissions + $approvedCommissions + $paidCommissions, 2),
            ],
            'recent_conversions' => $recentConversions,
            'top_links' => $topLinks,
        ]);
    }

    public function earnings(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $period = $request->get('period', '30'); // days

        $startDate = now()->subDays((int) $period);

        $dailyEarnings = Commission::where('user_id', $userId)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total, status')
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        $commissionsByProgram = Commission::where('user_id', $userId)
            ->with('conversion.trackingLink.enrollment.program')
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function ($commission) {
                return $commission->conversion?->trackingLink?->enrollment?->program?->name ?? 'Unknown';
            })
            ->map(function ($commissions) {
                return [
                    'count' => $commissions->count(),
                    'total' => $commissions->sum('amount'),
                ];
            });

        return response()->json([
            'period_days' => (int) $period,
            'daily_earnings' => $dailyEarnings,
            'by_program' => $commissionsByProgram,
        ]);
    }
}
