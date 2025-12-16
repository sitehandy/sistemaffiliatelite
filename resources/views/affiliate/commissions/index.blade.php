@extends('layouts.app')
@section('title', 'Commissions')
@section('page-title', 'My Commissions')

@section('content')
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-yellow-50 rounded-lg p-4"><p class="text-sm text-yellow-600">Pending</p><p class="text-2xl font-bold text-yellow-800">${{ number_format($stats['pending_total'], 2) }}</p></div>
        <div class="bg-green-50 rounded-lg p-4"><p class="text-sm text-green-600">Approved</p><p class="text-2xl font-bold text-green-800">${{ number_format($stats['approved_total'], 2) }}</p></div>
        <div class="bg-blue-50 rounded-lg p-4"><p class="text-sm text-blue-600">Paid</p><p class="text-2xl font-bold text-blue-800">${{ number_format($stats['paid_total'], 2) }}</p></div>
    </div>

    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-2">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($commissions as $commission)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $commission->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $commission->conversion?->trackingEvent?->trackingLink?->program?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $commission->conversion?->trackingEvent?->trackingLink?->product?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-green-600">${{ number_format($commission->amount, 2) }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full @if($commission->status==='pending')bg-yellow-100 text-yellow-800 @elseif($commission->status==='approved')bg-green-100 text-green-800 @else bg-blue-100 text-blue-800 @endif">{{ ucfirst($commission->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No commissions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $commissions->links() }}</div>
@endsection
