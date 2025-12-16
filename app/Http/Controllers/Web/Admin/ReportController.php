<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use App\Models\Commission;
use App\Models\Conversion;
use App\Models\Payout;
use App\Models\Product;
use App\Models\TrackingEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function overview(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $stats = [
            'total_clicks' => TrackingEvent::where('event_type', 'click')
                ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->count(),
            'total_conversions' => Conversion::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->count(),
            'total_revenue' => Conversion::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->sum('conversion_value'),
            'total_commissions' => Commission::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->sum('amount'),
            'total_payouts' => Payout::completed()
                ->whereBetween('processed_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->sum('total_amount'),
        ];

        // Daily stats for chart
        $dailyStats = $this->getDailyStats($dateFrom, $dateTo);

        return view('admin.reports.overview', compact('stats', 'dailyStats', 'dateFrom', 'dateTo'));
    }

    public function affiliates(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $affiliates = User::whereHas('role', fn($q) => $q->where('name', 'affiliate'))
            ->withCount(['trackingLinks'])
            ->withSum(['commissions' => fn($q) => $q->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])], 'amount')
            ->withCount(['commissions' => fn($q) => $q->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->orderByDesc('commissions_sum_amount')
            ->paginate(20);

        return view('admin.reports.affiliates', compact('affiliates', 'dateFrom', 'dateTo'));
    }

    public function programs(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $programs = AffiliateProgram::withCount(['enrollments', 'conversions' => fn($q) => $q->whereBetween('conversions.created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->with(['conversions' => fn($q) => $q->whereBetween('conversions.created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->get()
            ->map(function ($program) {
                $program->total_revenue = $program->conversions->sum('conversion_value');
                return $program;
            })
            ->sortByDesc('conversions_count');

        return view('admin.reports.programs', compact('programs', 'dateFrom', 'dateTo'));
    }

    public function products(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $products = Product::withCount(['trackingLinks', 'conversions' => fn($q) => $q->whereBetween('conversions.created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->with(['conversions' => fn($q) => $q->whereBetween('conversions.created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->get()
            ->map(function ($product) {
                $product->total_revenue = $product->conversions->sum('conversion_value');
                return $product;
            })
            ->sortByDesc('conversions_count');

        return view('admin.reports.products', compact('products', 'dateFrom', 'dateTo'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'overview');
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $data = match ($type) {
            'affiliates' => $this->getAffiliatesExportData($dateFrom, $dateTo),
            'programs' => $this->getProgramsExportData($dateFrom, $dateTo),
            'commissions' => $this->getCommissionsExportData($dateFrom, $dateTo),
            default => $this->getOverviewExportData($dateFrom, $dateTo),
        };

        $filename = "{$type}_report_{$dateFrom}_{$dateTo}.csv";

        return response()->streamDownload(function () use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function getDailyStats(string $dateFrom, string $dateTo): array
    {
        $clicks = TrackingEvent::where('event_type', 'click')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $conversions = Conversion::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $commissions = Commission::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $dates = collect();
        $current = \Carbon\Carbon::parse($dateFrom);
        $end = \Carbon\Carbon::parse($dateTo);

        while ($current <= $end) {
            $dates->push($current->format('Y-m-d'));
            $current->addDay();
        }

        return [
            'labels' => $dates->map(fn($d) => date('M d', strtotime($d)))->toArray(),
            'clicks' => $dates->map(fn($d) => $clicks[$d] ?? 0)->toArray(),
            'conversions' => $dates->map(fn($d) => $conversions[$d] ?? 0)->toArray(),
            'commissions' => $dates->map(fn($d) => (float) ($commissions[$d] ?? 0))->toArray(),
        ];
    }

    private function getAffiliatesExportData(string $dateFrom, string $dateTo): array
    {
        $data = [['Name', 'Email', 'Tracking Links', 'Commissions', 'Total Earnings']];

        User::whereHas('role', fn($q) => $q->where('name', 'affiliate'))
            ->withCount(['trackingLinks'])
            ->withSum(['commissions' => fn($q) => $q->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])], 'amount')
            ->withCount(['commissions' => fn($q) => $q->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->chunk(100, function ($affiliates) use (&$data) {
                foreach ($affiliates as $affiliate) {
                    $data[] = [
                        $affiliate->name,
                        $affiliate->email,
                        $affiliate->tracking_links_count,
                        $affiliate->commissions_count,
                        number_format($affiliate->commissions_sum_amount ?? 0, 2),
                    ];
                }
            });

        return $data;
    }

    private function getProgramsExportData(string $dateFrom, string $dateTo): array
    {
        $data = [['Program', 'Type', 'Commission', 'Enrollments', 'Conversions', 'Revenue']];

        AffiliateProgram::withCount(['enrollments', 'conversions' => fn($q) => $q->whereBetween('conversions.created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->with(['conversions' => fn($q) => $q->whereBetween('conversions.created_at', [$dateFrom, $dateTo . ' 23:59:59'])])
            ->chunk(100, function ($programs) use (&$data) {
                foreach ($programs as $program) {
                    $data[] = [
                        $program->name,
                        $program->program_type,
                        $program->commission_type === 'percentage' ? $program->commission_amount . '%' : '$' . $program->commission_amount,
                        $program->enrollments_count,
                        $program->conversions_count,
                        number_format($program->conversions->sum('conversion_value'), 2),
                    ];
                }
            });

        return $data;
    }

    private function getCommissionsExportData(string $dateFrom, string $dateTo): array
    {
        $data = [['Date', 'Affiliate', 'Program', 'Amount', 'Status']];

        Commission::with(['user', 'conversion.trackingEvent.trackingLink.program'])
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->chunk(100, function ($commissions) use (&$data) {
                foreach ($commissions as $commission) {
                    $data[] = [
                        $commission->created_at->format('Y-m-d H:i'),
                        $commission->user->name,
                        $commission->conversion?->trackingEvent?->trackingLink?->program?->name ?? 'N/A',
                        number_format($commission->amount, 2),
                        $commission->status,
                    ];
                }
            });

        return $data;
    }

    private function getOverviewExportData(string $dateFrom, string $dateTo): array
    {
        $data = [['Metric', 'Value']];

        $data[] = ['Date Range', "{$dateFrom} to {$dateTo}"];
        $data[] = ['Total Clicks', TrackingEvent::where('event_type', 'click')->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->count()];
        $data[] = ['Total Conversions', Conversion::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->count()];
        $data[] = ['Total Revenue', number_format(Conversion::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('conversion_value'), 2)];
        $data[] = ['Total Commissions', number_format(Commission::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('amount'), 2)];
        $data[] = ['Total Payouts', number_format(Payout::completed()->whereBetween('processed_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('total_amount'), 2)];

        return $data;
    }
}
