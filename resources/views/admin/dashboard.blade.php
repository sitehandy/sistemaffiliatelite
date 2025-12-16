@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Affiliates</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_affiliates']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Active Programs</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['active_programs'] }} / {{ $stats['total_programs'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Clicks</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_clicks']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Conversions</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_conversions']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending Enrollments</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['pending_enrollments'] }}</p>
                </div>
                <a href="{{ route('admin.enrollments.index', ['status' => 'pending']) }}" class="text-blue-600 hover:text-blue-800 text-sm">View all</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending Commissions</p>
                    <p class="text-2xl font-semibold text-gray-800">${{ number_format($stats['pending_commissions'], 2) }}</p>
                </div>
                <a href="{{ route('admin.commissions.index', ['status' => 'pending']) }}" class="text-blue-600 hover:text-blue-800 text-sm">View all</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending Payouts</p>
                    <p class="text-2xl font-semibold text-gray-800">${{ number_format($stats['pending_payouts'], 2) }}</p>
                </div>
                <a href="{{ route('admin.payouts.index', ['status' => 'pending']) }}" class="text-blue-600 hover:text-blue-800 text-sm">View all</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Performance Overview (Last 6 Months)</h3>
            <canvas id="performanceChart" height="200"></canvas>
        </div>

        <!-- Top Affiliates -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Affiliates</h3>
            <div class="space-y-4">
                @forelse($topAffiliates as $affiliate)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($affiliate->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-800">{{ $affiliate->name }}</p>
                                <p class="text-xs text-gray-500">{{ $affiliate->email }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-semibold text-green-600">${{ number_format($affiliate->commissions_sum_amount ?? 0, 2) }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No affiliates yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Enrollments -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Enrollments</h3>
                <a href="{{ route('admin.enrollments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all</a>
            </div>
            <div class="space-y-4">
                @forelse($recentEnrollments as $enrollment)
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $enrollment->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $enrollment->program->name }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($enrollment->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($enrollment->status === 'approved') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No recent enrollments.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Commissions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Commissions</h3>
                <a href="{{ route('admin.commissions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all</a>
            </div>
            <div class="space-y-4">
                @forelse($recentCommissions as $commission)
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $commission->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $commission->conversion?->trackingEvent?->trackingLink?->program?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600">${{ number_format($commission->amount, 2) }}</p>
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($commission->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($commission->status === 'approved') bg-green-100 text-green-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($commission->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No recent commissions.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($monthlyStats['labels']),
            datasets: [
                {
                    label: 'Clicks',
                    data: @json($monthlyStats['clicks']),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.3,
                },
                {
                    label: 'Conversions',
                    data: @json($monthlyStats['conversions']),
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.3,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
