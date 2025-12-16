@extends('layouts.app')

@section('title', 'Affiliate Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Announcements -->
    @if($announcements->count() > 0)
        <div class="mb-8 space-y-4">
            @foreach($announcements as $announcement)
                <div class="rounded-lg p-4 flex items-start
                    @if($announcement->type === 'info') bg-blue-50 border border-blue-200
                    @elseif($announcement->type === 'success') bg-green-50 border border-green-200
                    @elseif($announcement->type === 'warning') bg-yellow-50 border border-yellow-200
                    @else bg-red-50 border border-red-200 @endif">
                    <div class="flex-shrink-0 mr-3">
                        @if($announcement->type === 'info')
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($announcement->type === 'success')
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($announcement->type === 'warning')
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center">
                            <h4 class="text-sm font-semibold
                                @if($announcement->type === 'info') text-blue-800
                                @elseif($announcement->type === 'success') text-green-800
                                @elseif($announcement->type === 'warning') text-yellow-800
                                @else text-red-800 @endif">
                                @if($announcement->is_pinned)
                                    <span class="mr-1">&#128204;</span>
                                @endif
                                {{ $announcement->title }}
                            </h4>
                            <span class="ml-2 text-xs
                                @if($announcement->type === 'info') text-blue-500
                                @elseif($announcement->type === 'success') text-green-500
                                @elseif($announcement->type === 'warning') text-yellow-600
                                @else text-red-500 @endif">
                                {{ $announcement->published_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="mt-1 text-sm prose prose-sm max-w-none
                            @if($announcement->type === 'info') text-blue-700 prose-blue
                            @elseif($announcement->type === 'success') text-green-700 prose-green
                            @elseif($announcement->type === 'warning') text-yellow-700 prose-yellow
                            @else text-red-700 prose-red @endif">
                            {!! $announcement->content !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
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
                <div class="p-3 rounded-full bg-green-100 text-green-600">
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

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Earnings</p>
                    <p class="text-2xl font-semibold text-gray-800">${{ number_format($stats['total_earnings'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Available Balance</p>
                    <p class="text-2xl font-semibold text-gray-800">${{ number_format($stats['available_balance'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending Commissions</p>
                    <p class="text-2xl font-semibold text-yellow-600">${{ number_format($stats['pending_commissions'], 2) }}</p>
                </div>
                <a href="{{ route('affiliate.commissions.index', ['status' => 'pending']) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Approved Commissions</p>
                    <p class="text-2xl font-semibold text-green-600">${{ number_format($stats['approved_commissions'], 2) }}</p>
                </div>
                <a href="{{ route('affiliate.commissions.index', ['status' => 'approved']) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Paid</p>
                    <p class="text-2xl font-semibold text-blue-600">${{ number_format($stats['total_paid'], 2) }}</p>
                </div>
                <a href="{{ route('affiliate.payouts.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Earnings Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Earnings</h3>
            <canvas id="earningsChart" height="200"></canvas>
        </div>

        <!-- Active Programs -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">My Programs</h3>
                <a href="{{ route('affiliate.programs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Browse More</a>
            </div>
            <div class="space-y-4">
                @forelse($activePrograms as $program)
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $program->name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ ucfirst($program->program_type) }} -
                                @if($program->commission_type === 'percentage')
                                    {{ $program->commission_amount }}%
                                @else
                                    ${{ number_format($program->commission_amount, 2) }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('affiliate.links.create') }}" class="text-blue-600 hover:text-blue-800 text-sm">Create Link</a>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500 mb-2">You haven't joined any programs yet.</p>
                        <a href="{{ route('affiliate.programs.index') }}" class="text-blue-600 hover:text-blue-800">Browse Programs</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Commissions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Recent Commissions</h3>
            <a href="{{ route('affiliate.commissions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentCommissions as $commission)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $commission->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $commission->conversion?->trackingEvent?->trackingLink?->program?->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-green-600">${{ number_format($commission->amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($commission->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($commission->status === 'approved') bg-green-100 text-green-800
                                    @elseif($commission->status === 'paid') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($commission->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">No commissions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($stats['available_balance'] > 0)
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center justify-between">
            <div>
                <p class="text-blue-800 font-medium">You have ${{ number_format($stats['available_balance'], 2) }} available for withdrawal</p>
                <p class="text-blue-600 text-sm">Request a payout to receive your earnings.</p>
            </div>
            <a href="{{ route('affiliate.payouts.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Request Payout</a>
        </div>
    @endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($monthlyEarnings['labels']),
            datasets: [{
                label: 'Earnings ($)',
                data: @json($monthlyEarnings['data']),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
