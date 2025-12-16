@extends('layouts.app')
@section('title', 'Payment Methods')
@section('page-title', 'Payment Methods')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Your Payment Methods</h3>
            @forelse($paymentMethods as $method)
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 uppercase">{{ $method->type }}</span>
                            <div class="mt-2 text-sm text-gray-700">
                                @if($method->type === 'bank')
                                    <p>{{ $method->masked_details['bank_name'] ?? '' }}</p>
                                    <p class="text-gray-500">{{ $method->masked_details['account_number'] ?? '' }}</p>
                                @else
                                    <p>{{ $method->masked_details['email'] ?? '' }}</p>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Added {{ $method->created_at->diffForHumans() }}</p>
                        </div>
                        <form method="POST" action="{{ route('affiliate.payment-methods.destroy', $method) }}" onsubmit="return confirm('Are you sure you want to remove this payment method?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Remove</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">No payment methods added yet.</div>
            @endforelse
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-4">Add Payment Method</h3>
            <form method="POST" action="{{ route('affiliate.payment-methods.store') }}" class="bg-white rounded-lg shadow p-6" x-data="{ type: 'paypal' }">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Type</label>
                    <select name="type" x-model="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="paypal">PayPal</option>
                        <option value="wise">Wise</option>
                        <option value="bank">Bank Transfer</option>
                    </select>
                </div>

                <div x-show="type === 'paypal' || type === 'wise'" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="details[email]" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="your@email.com">
                </div>

                <div x-show="type === 'bank'">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                        <input type="text" name="details[bank_name]" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name</label>
                        <input type="text" name="details[account_name]" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                        <input type="text" name="details[account_number]" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">SWIFT Code (optional)</label>
                        <input type="text" name="details[swift_code]" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Payment Method</button>
            </form>
        </div>
    </div>
@endsection
