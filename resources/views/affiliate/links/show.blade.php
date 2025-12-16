@extends('layouts.app')
@section('title', 'Link Statistics')
@section('page-title', 'Link Statistics')

@section('content')
    <div class="mb-6">
        <a href="{{ route('affiliate.links.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Back to Links
        </a>
    </div>

    <!-- Link Info -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $link->product?->name ?? 'All Products (Default URL)' }}</h2>
                <p class="text-gray-500 mt-1">{{ $link->program->name }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex items-center space-x-2">
                    <input type="text" readonly value="{{ url('/track/' . $link->unique_code) }}"
                           class="text-sm px-3 py-2 border border-gray-300 rounded-lg w-64" id="tracking-url">
                    <button onclick="copyToClipboard()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Copy Link
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Clicks</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_clicks']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Unique Clicks</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['unique_clicks']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Conversions</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_conversions']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Earnings</p>
                    <p class="text-2xl font-semibold text-gray-900">${{ number_format($stats['total_earnings'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversion Rate -->
    @if($stats['total_clicks'] > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Conversion Rate</h3>
        <div class="flex items-center">
            <div class="flex-1 bg-gray-200 rounded-full h-4 mr-4">
                @php
                    $conversionRate = ($stats['total_conversions'] / $stats['total_clicks']) * 100;
                @endphp
                <div class="bg-green-500 h-4 rounded-full" style="width: {{ min($conversionRate, 100) }}%"></div>
            </div>
            <span class="text-lg font-semibold text-gray-900">{{ number_format($conversionRate, 2) }}%</span>
        </div>
    </div>
    @endif

    <!-- Recent Events -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Events</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referrer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentEvents as $event)
                    <tr>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($event->event_type === 'click') bg-blue-100 text-blue-800
                                @elseif($event->event_type === 'conversion') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($event->event_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $event->ip_address ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $event->referrer ?? 'Direct' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $event->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No events recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard() {
            const input = document.getElementById('tracking-url');
            input.select();
            navigator.clipboard.writeText(input.value);
            alert('Link copied to clipboard!');
        }
    </script>
    @endpush
@endsection
