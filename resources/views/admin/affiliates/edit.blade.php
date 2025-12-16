@extends('layouts.app')
@section('title', 'Edit Affiliate')
@section('page-title', 'Edit Affiliate: ' . $affiliate->name)

@section('content')
    <div class="max-w-2xl space-y-6">
        <!-- Edit Profile Form -->
        <form method="POST" action="{{ route('admin.affiliates.update', $affiliate) }}" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h3>

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $affiliate->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $affiliate->email) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600"
                        {{ old('is_active', $affiliate->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Account Info</h3>
                <div class="text-sm text-gray-600 space-y-1">
                    <p><span class="font-medium">Joined:</span> {{ $affiliate->created_at->format('M d, Y') }}</p>
                    <p><span class="font-medium">Email Verified:</span> {{ $affiliate->email_verified_at ? $affiliate->email_verified_at->format('M d, Y') : 'Not verified' }}</p>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.affiliates.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Affiliate
                </button>
            </div>
        </form>

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('admin.affiliates.reset-password', $affiliate) }}" class="bg-white rounded-lg shadow p-6">
            @csrf

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reset Password</h3>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
@endsection
