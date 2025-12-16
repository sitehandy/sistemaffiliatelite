@extends('layouts.app')
@section('title', 'Profile')
@section('page-title', 'Profile Settings')

@php
    $isDemoAdmin = config('app.demo_mode') && auth()->user()->role?->name === 'admin';
@endphp

@section('content')
    <div class="max-w-2xl space-y-6">
        @if($isDemoAdmin)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Demo Mode Active</h4>
                        <p class="text-sm text-yellow-700 mt-1">Admin profile cannot be modified in demo mode.</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="bg-white rounded-lg shadow p-6">
            @csrf @method('PUT')
            <fieldset {{ $isDemoAdmin ? 'disabled' : '' }}>
            <h3 class="text-lg font-semibold mb-4">Profile Information</h3>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('email') border-red-500 @enderror">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $isDemoAdmin ? 'disabled' : '' }}>Save Changes</button>
            </div>
            </fieldset>
        </form>

        <form method="POST" action="{{ route('profile.password') }}" class="bg-white rounded-lg shadow p-6">
            @csrf @method('PUT')
            <fieldset {{ $isDemoAdmin ? 'disabled' : '' }}>
            <h3 class="text-lg font-semibold mb-4">Change Password</h3>
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" id="current_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('current_password') border-red-500 @enderror">
                @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('password') border-red-500 @enderror">
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $isDemoAdmin ? 'disabled' : '' }}>Update Password</button>
            </div>
            </fieldset>
        </form>
    </div>
@endsection
