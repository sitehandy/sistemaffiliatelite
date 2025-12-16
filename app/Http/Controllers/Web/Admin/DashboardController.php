<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use App\Models\Commission;
use App\Models\Conversion;
use App\Models\Payout;
use App\Models\ProgramEnrollment;
use App\Models\TrackingEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_affiliates' => User::whereHas('role', fn($q) => $q->where('name', 'affiliate'))->count(),
            'total_programs' => AffiliateProgram::count(),
            'active_programs' => AffiliateProgram::where('is_active', true)->count(),
            'pending_enrollments' => ProgramEnrollment::where('status', 'pending')->count(),
            'total_clicks' => TrackingEvent::where('event_type', 'click')->count(),
            'total_conversions' => Conversion::count(),
            'pending_commissions' => Commission::where('status', 'pending')->sum('amount'),
            'pending_payouts' => Payout::where('status', 'pending')->sum('total_amount'),
        ];

        // Recent enrollments
        $recentEnrollments = ProgramEnrollment::with(['user', 'program'])
            ->latest()
            ->take(5)
            ->get();

        // Recent commissions
        $recentCommissions = Commission::with(['user', 'conversion.trackingEvent.trackingLink.program'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly stats for chart
        $monthlyStats = $this->getMonthlyStats();

        // Top affiliates
        $topAffiliates = User::whereHas('role', fn($q) => $q->where('name', 'affiliate'))
            ->withSum(['commissions' => fn($q) => $q->where('status', 'approved')], 'amount')
            ->orderByDesc('commissions_sum_amount')
            ->take(5)
            ->get();

        // Top programs
        $topPrograms = AffiliateProgram::withCount('enrollments')
            ->with('trackingLinks')
            ->get()
            ->map(function ($program) {
                $program->conversions_count = Conversion::whereHas('trackingEvent.trackingLink', function ($query) use ($program) {
                    $query->where('program_id', $program->id);
                })->count();
                return $program;
            })
            ->sortByDesc('conversions_count')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'stats',
            'recentEnrollments',
            'recentCommissions',
            'monthlyStats',
            'topAffiliates',
            'topPrograms'
        ));
    }

    private function getMonthlyStats(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $clicks = TrackingEvent::where('event_type', 'click')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        $conversions = Conversion::where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        $commissions = Commission::where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return [
            'labels' => $months->map(fn($m) => date('M Y', strtotime($m . '-01')))->toArray(),
            'clicks' => $months->map(fn($m) => $clicks[$m] ?? 0)->toArray(),
            'conversions' => $months->map(fn($m) => $conversions[$m] ?? 0)->toArray(),
            'commissions' => $months->map(fn($m) => (float) ($commissions[$m] ?? 0))->toArray(),
        ];
    }
}
