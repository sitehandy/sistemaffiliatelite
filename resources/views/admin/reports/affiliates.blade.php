@extends('layouts.app')
@section('title', 'Affiliates Report')
@section('page-title', 'Affiliates Report')

@section('content')
    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">From</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">To</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="pt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Apply</button>
            </div>
            <div class="pt-6">
                <a href="{{ route('admin.reports.export', ['type' => 'affiliates', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Export CSV</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Affiliate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tracking Links</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commissions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Earnings</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($affiliates as $affiliate)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $affiliate->name }}</div>
                            <div class="text-sm text-gray-500">{{ $affiliate->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $affiliate->tracking_links_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $affiliate->commissions_count }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-green-600">${{ number_format($affiliate->commissions_sum_amount ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.affiliates.show', $affiliate) }}" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No affiliates found for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $affiliates->appends(request()->query())->links() }}</div>
@endsection
