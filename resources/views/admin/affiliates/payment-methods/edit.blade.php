@extends('layouts.app')
@section('title', 'Edit Payment Method')
@section('page-title', 'Edit Payment Method for ' . $affiliate->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.affiliates.show', $affiliate) }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Affiliate</a>
    </div>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.affiliates.payment-methods.update', [$affiliate, $paymentMethod]) }}" class="bg-white rounded-lg shadow p-6" x-data="{ type: '{{ old('type', $paymentMethod->type) }}' }">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Payment Type</label>
                <select name="type" id="type" x-model="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="bank">Bank Transfer</option>
                    <option value="paypal">PayPal</option>
                    <option value="wise">Wise</option>
                </select>
            </div>

            <!-- Bank Fields -->
            <div x-show="type === 'bank'" class="space-y-4">
                <div>
                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                    <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $paymentMethod->details['bank_name'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('bank_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="account_name" class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name</label>
                    <input type="text" name="account_name" id="account_name" value="{{ old('account_name', $paymentMethod->details['account_name'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('account_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="account_number" class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                    <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $paymentMethod->details['account_number'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('account_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="routing_number" class="block text-sm font-medium text-gray-700 mb-1">Routing Number</label>
                        <input type="text" name="routing_number" id="routing_number" value="{{ old('routing_number', $paymentMethod->details['routing_number'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="swift_code" class="block text-sm font-medium text-gray-700 mb-1">SWIFT Code</label>
                        <input type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', $paymentMethod->details['swift_code'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- PayPal/Wise Fields -->
            <div x-show="type === 'paypal' || type === 'wise'" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        <span x-show="type === 'paypal'">PayPal Email</span>
                        <span x-show="type === 'wise'">Wise Email</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $paymentMethod->details['email'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-6 pt-6 border-t space-y-4">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600"
                            {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_verified" value="1" class="rounded border-gray-300 text-blue-600"
                            {{ old('is_verified', $paymentMethod->is_verified) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Verified</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.affiliates.show', $affiliate) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Payment Method
                </button>
            </div>
        </form>

        <!-- Delete Form (separate) -->
        <form method="POST" action="{{ route('admin.affiliates.payment-methods.destroy', [$affiliate, $paymentMethod]) }}" onsubmit="return confirm('Are you sure you want to delete this payment method?')" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Delete Payment Method
            </button>
        </form>
    </div>
@endsection
