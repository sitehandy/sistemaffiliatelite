@extends('layouts.app')
@section('title', 'Overview Report')
@section('page-title', 'Overview Report')

@section('content')
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form method="GET" class="flex items-center space-x-4">
            <div><label class="block text-sm text-gray-600">From</label><input type="date" name="date_from" value="{{ $dateFrom }}" class="px-4 py-2 border border-gray-300 rounded-lg"></div>
            <div><label class="block text-sm text-gray-600">To</label><input type="date" name="date_to" value="{{ $dateTo }}" class="px-4 py-2 border border-gray-300 rounded-lg"></div>
            <div class="pt-5"><button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Apply</button></div>
            <div class="pt-5"><a href="{{ route('admin.reports.export', ['type' => 'overview', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Export CSV</a></div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-4"><p class="text-sm text-gray-500">Clicks</p><p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_clicks']) }}</p></div>
        <div class="bg-white rounded-lg shadow p-4"><p class="text-sm text-gray-500">Conversions</p><p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_conversions']) }}</p></div>
        <div class="bg-white rounded-lg shadow p-4"><p class="text-sm text-gray-500">Revenue</p><p class="text-2xl font-bold text-purple-600">${{ number_format($stats['total_revenue'], 2) }}</p></div>
        <div class="bg-white rounded-lg shadow p-4"><p class="text-sm text-gray-500">Commissions</p><p class="text-2xl font-bold text-yellow-600">${{ number_format($stats['total_commissions'], 2) }}</p></div>
        <div class="bg-white rounded-lg shadow p-4"><p class="text-sm text-gray-500">Payouts</p><p class="text-2xl font-bold text-indigo-600">${{ number_format($stats['total_payouts'], 2) }}</p></div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Daily Performance</h3>
        <canvas id="chart" height="100"></canvas>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chart').getContext('2d'), {
    type: 'line',
    data: {
        labels: @json($dailyStats['labels']),
        datasets: [
            { label: 'Clicks', data: @json($dailyStats['clicks']), borderColor: 'rgb(59, 130, 246)', tension: 0.3 },
            { label: 'Conversions', data: @json($dailyStats['conversions']), borderColor: 'rgb(16, 185, 129)', tension: 0.3 }
        ]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});
</script>
@endpush
