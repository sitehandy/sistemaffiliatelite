@extends('layouts.app')

@section('title', 'App Settings')
@section('page-title', 'Application Settings')

@section('content')
    <div class="max-w-3xl">
        @if(config('app.demo_mode'))
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Demo Mode Active</h4>
                        <p class="text-sm text-yellow-700 mt-1">App settings cannot be modified in demo mode.</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.app.update') }}" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')
            <fieldset {{ config('app.demo_mode') ? 'disabled' : '' }}>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">General Settings</h3>
                <p class="text-sm text-gray-500">Configure your application name and URL.</p>
            </div>

            <div class="mb-6">
                <label for="app_name" class="block text-sm font-medium text-gray-700 mb-1">Application Name</label>
                <input type="text" name="app_name" id="app_name" value="{{ $settings['app_name'] }}" required
                    placeholder="My Affiliate System"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('app_name') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">This name will be displayed in the browser title and emails.</p>
                @error('app_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="app_url" class="block text-sm font-medium text-gray-700 mb-1">Application URL</label>
                <input type="url" name="app_url" id="app_url" value="{{ $settings['app_url'] }}" required
                    placeholder="https://example.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('app_url') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">The base URL of your application (without trailing slash).</p>
                @error('app_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6">

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Environment Settings</h3>
                <p class="text-sm text-gray-500">Configure your application environment and debug mode.</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="app_env" class="block text-sm font-medium text-gray-700 mb-1">Environment</label>
                    <select name="app_env" id="app_env" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('app_env') border-red-500 @enderror">
                        <option value="local" {{ $settings['app_env'] === 'local' ? 'selected' : '' }}>Local (Development)</option>
                        <option value="staging" {{ $settings['app_env'] === 'staging' ? 'selected' : '' }}>Staging (Testing)</option>
                        <option value="production" {{ $settings['app_env'] === 'production' ? 'selected' : '' }}>Production (Live)</option>
                    </select>
                    @error('app_env')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="app_debug" class="block text-sm font-medium text-gray-700 mb-1">Debug Mode</label>
                    <select name="app_debug" id="app_debug" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('app_debug') border-red-500 @enderror">
                        <option value="false" {{ !filter_var($settings['app_debug'], FILTER_VALIDATE_BOOLEAN) ? 'selected' : '' }}>Disabled (Recommended for Production)</option>
                        <option value="true" {{ filter_var($settings['app_debug'], FILTER_VALIDATE_BOOLEAN) ? 'selected' : '' }}>Enabled (Development Only)</option>
                    </select>
                    @error('app_debug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Warning for Debug Mode -->
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Security Warning</h4>
                        <p class="text-sm text-yellow-700 mt-1">
                            <strong>Never enable debug mode in production!</strong> Debug mode exposes sensitive information including database credentials, environment variables, and stack traces.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ config('app.demo_mode') ? 'disabled' : '' }}>
                    Save App Settings
                </button>
            </div>
            </fieldset>
        </form>

        <!-- Current Configuration Display -->
        <div class="mt-6 bg-gray-50 rounded-lg p-6">
            <h4 class="text-sm font-semibold text-gray-900 mb-4">Current Configuration</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">App Name:</span>
                    <span class="ml-2 font-medium text-gray-900">{{ config('app.name') }}</span>
                </div>
                <div>
                    <span class="text-gray-500">App URL:</span>
                    <span class="ml-2 font-medium text-gray-900">{{ config('app.url') }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Environment:</span>
                    <span class="ml-2 px-2 py-0.5 rounded text-xs font-medium
                        @if(config('app.env') === 'production') bg-green-100 text-green-800
                        @elseif(config('app.env') === 'staging') bg-yellow-100 text-yellow-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst(config('app.env')) }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500">Debug Mode:</span>
                    <span class="ml-2 px-2 py-0.5 rounded text-xs font-medium
                        @if(config('app.debug')) bg-red-100 text-red-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500">PHP Version:</span>
                    <span class="ml-2 font-medium text-gray-900">{{ PHP_VERSION }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Laravel Version:</span>
                    <span class="ml-2 font-medium text-gray-900">{{ app()->version() }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
