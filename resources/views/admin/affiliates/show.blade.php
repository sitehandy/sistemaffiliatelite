@extends('layouts.app')
@section('title', 'Affiliate Details')
@section('page-title', 'Affiliate: ' . $affiliate->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.affiliates.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Affiliates</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Affiliate Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        {{ strtoupper(substr($affiliate->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $affiliate->name }}</h2>
                    <p class="text-gray-500">{{ $affiliate->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full {{ $affiliate->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $affiliate->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="border-t pt-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Joined</span>
                        <span class="text-gray-900">{{ $affiliate->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Email Verified</span>
                        <span class="text-gray-900">{{ $affiliate->email_verified_at ? 'Yes' : 'No' }}</span>
                    </div>
                </div>

                <div class="mt-6 flex space-x-2">
                    <a href="{{ route('admin.affiliates.edit', $affiliate) }}" class="flex-1 px-4 py-2 bg-blue-600 text-white text-center text-sm rounded-lg hover:bg-blue-700">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.affiliates.toggle-status', $affiliate) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 {{ $affiliate->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }} text-white text-sm rounded-lg">
                            {{ $affiliate->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Stats & Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Total Commissions</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_commissions'], 2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">${{ number_format($stats['pending_commissions'], 2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Approved</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($stats['approved_commissions'], 2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Total Clicks</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_clicks']) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Conversions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_conversions']) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Active Programs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_programs'] }}</p>
                </div>
            </div>

            <!-- Enrolled Programs -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Enrolled Programs</h3>
                </div>
                <div class="divide-y">
                    @forelse($affiliate->enrollments as $enrollment)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $enrollment->program->name }}</p>
                                <p class="text-sm text-gray-500">Enrolled {{ $enrollment->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($enrollment->status === 'approved') bg-green-100 text-green-800
                                @elseif($enrollment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($enrollment->status === 'suspended') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500">No program enrollments.</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Commissions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Commissions</h3>
                </div>
                <div class="divide-y">
                    @forelse($affiliate->commissions->take(5) as $commission)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">${{ number_format($commission->amount, 2) }}</p>
                                <p class="text-sm text-gray-500">{{ $commission->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($commission->status === 'approved') bg-green-100 text-green-800
                                @elseif($commission->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($commission->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500">No commissions yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Payment Methods</h3>
                    <a href="{{ route('admin.affiliates.payment-methods.create', $affiliate) }}" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700">
                        + Add
                    </a>
                </div>
                <div class="divide-y">
                    @forelse($affiliate->paymentMethods as $method)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 uppercase">
                                        {{ $method->type }}
                                    </span>
                                    @if($method->is_active)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                    @endif
                                    @if($method->is_verified)
                                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Verified</span>
                                    @endif
                                </div>
                                <a href="{{ route('admin.affiliates.payment-methods.edit', [$affiliate, $method]) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Edit
                                </a>
                            </div>
                            <div class="text-sm text-gray-600">
                                @if($method->type === 'bank')
                                    <p><span class="font-medium">Bank:</span> {{ $method->details['bank_name'] ?? 'N/A' }}</p>
                                    <p><span class="font-medium">Account:</span> {{ $method->details['account_number'] ?? 'N/A' }}</p>
                                    <p><span class="font-medium">Account Name:</span> {{ $method->details['account_name'] ?? 'N/A' }}</p>
                                @elseif($method->type === 'paypal')
                                    <p><span class="font-medium">PayPal Email:</span> {{ $method->details['email'] ?? 'N/A' }}</p>
                                @elseif($method->type === 'wise')
                                    <p><span class="font-medium">Wise Email:</span> {{ $method->details['email'] ?? 'N/A' }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500">No payment methods configured.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
