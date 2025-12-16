@extends('layouts.app')
@section('title', 'Payouts')
@section('page-title', 'My Payouts')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Available Balance</h3>
            <p class="text-3xl font-bold text-green-600">${{ number_format($availableBalance, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">Minimum payout: ${{ number_format($minPayoutAmount, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Request Payout</h3>
            @if($paymentMethods->isEmpty())
                <p class="text-sm text-gray-500 mb-2">Add a payment method first.</p>
                <a href="{{ route('affiliate.payment-methods.index') }}" class="text-blue-600 hover:underline">Add Payment Method</a>
            @elseif($availableBalance < $minPayoutAmount)
                <p class="text-sm text-gray-500">Minimum balance of ${{ number_format($minPayoutAmount, 2) }} required.</p>
            @else
                <form method="POST" action="{{ route('affiliate.payouts.request') }}">
                    @csrf
                    <select name="payment_method_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3">
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ ucfirst($method->type) }} - {{ $method->masked_details }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Request Payout</button>
                </form>
            @endif
        </div>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Payout History</h3>
        <a href="{{ route('affiliate.payment-methods.index') }}" class="text-blue-600 hover:underline text-sm">Manage Payment Methods</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($payouts as $payout)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $payout->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm font-medium">${{ number_format($payout->total_amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucfirst($payout->paymentMethod?->type ?? 'N/A') }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full @if($payout->status==='pending')bg-yellow-100 text-yellow-800 @elseif($payout->status==='processing')bg-blue-100 text-blue-800 @elseif($payout->status==='completed')bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">{{ ucfirst($payout->status) }}</span></td>
                        <td class="px-6 py-4 text-right text-sm">
                            @if($payout->status === 'pending')
                                <form method="POST" action="{{ route('affiliate.payouts.cancel', $payout) }}" class="inline">@csrf<button type="submit" class="text-red-600 hover:text-red-900">Cancel</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No payout history.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payouts->links() }}</div>
@endsection
