@extends('layouts.app')
@section('title', 'Settings')
@section('page-title', 'System Settings')

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
                        <p class="text-sm text-yellow-700 mt-1">Settings cannot be modified in demo mode.</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white rounded-lg shadow p-6">
            @csrf @method('PUT')
            <fieldset {{ config('app.demo_mode') ? 'disabled' : '' }}>

            <div class="mb-6">
                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name']?->value ?? config('app.name')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="min_payout_amount" class="block text-sm font-medium text-gray-700 mb-1">Minimum Payout Amount ($)</label>
                    <input type="number" name="min_payout_amount" id="min_payout_amount" value="{{ old('min_payout_amount', $settings['min_payout_amount']?->value ?? 50) }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="default_cookie_duration" class="block text-sm font-medium text-gray-700 mb-1">Cookie Duration (days)</label>
                    <input type="number" name="default_cookie_duration" id="default_cookie_duration" value="{{ old('default_cookie_duration', $settings['default_cookie_duration']?->value ?? 30) }}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div class="mb-6">
                <label for="payout_schedule" class="block text-sm font-medium text-gray-700 mb-1">Payout Schedule</label>
                <select name="payout_schedule" id="payout_schedule" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="weekly" {{ ($settings['payout_schedule']?->value ?? 'monthly') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="biweekly" {{ ($settings['payout_schedule']?->value ?? 'monthly') === 'biweekly' ? 'selected' : '' }}>Bi-Weekly</option>
                    <option value="monthly" {{ ($settings['payout_schedule']?->value ?? 'monthly') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
            </div>

            <div class="mb-6 space-y-4">
                <label class="flex items-center">
                    <input type="checkbox" name="auto_approve_enrollments" value="1" class="rounded border-gray-300 text-blue-600" {{ ($settings['auto_approve_enrollments']?->value ?? 0) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Auto-approve enrollment requests</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="auto_approve_commissions" value="1" class="rounded border-gray-300 text-blue-600" {{ ($settings['auto_approve_commissions']?->value ?? 0) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Auto-approve commissions</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ config('app.demo_mode') ? 'disabled' : '' }}>Save Settings</button>
            </div>
            </fieldset>
        </form>
    </div>
@endsection
