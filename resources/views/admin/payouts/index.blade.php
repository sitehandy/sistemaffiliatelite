@extends('layouts.app')
@section('title', 'Payouts')
@section('page-title', 'Payouts')

@section('content')
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-yellow-50 rounded-lg p-4"><p class="text-sm text-yellow-600">Pending</p><p class="text-2xl font-bold text-yellow-800">${{ number_format($stats['pending_total'], 2) }}</p></div>
        <div class="bg-blue-50 rounded-lg p-4"><p class="text-sm text-blue-600">Processing</p><p class="text-2xl font-bold text-blue-800">${{ number_format($stats['processing_total'], 2) }}</p></div>
        <div class="bg-green-50 rounded-lg p-4"><p class="text-sm text-green-600">Completed</p><p class="text-2xl font-bold text-green-800">${{ number_format($stats['completed_total'], 2) }}</p></div>
    </div>

    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-2">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Affiliate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($payouts as $payout)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $payout->user->name }}</td>
                        <td class="px-6 py-4 text-sm font-medium">${{ number_format($payout->total_amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucfirst($payout->paymentMethod?->type ?? 'N/A') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $payout->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full @if($payout->status==='pending')bg-yellow-100 text-yellow-800 @elseif($payout->status==='processing')bg-blue-100 text-blue-800 @elseif($payout->status==='completed')bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">{{ ucfirst($payout->status) }}</span></td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.payouts.show', $payout) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                            @if($payout->status === 'pending')
                                <form method="POST" action="{{ route('admin.payouts.process', $payout) }}" class="inline">@csrf<button type="submit" class="text-green-600 hover:text-green-900">Process</button></form>
                            @elseif($payout->status === 'processing')
                                <form method="POST" action="{{ route('admin.payouts.complete', $payout) }}" class="inline">@csrf<button type="submit" class="text-green-600 hover:text-green-900">Complete</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No payouts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payouts->links() }}</div>
@endsection
