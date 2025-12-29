@extends('layouts.app')

@section('title', 'System Upgrade')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">System Upgrade</h1>
            <p class="text-gray-600 mt-1">Manage system updates and run database migrations</p>
        </div>
    </div>

    <!-- Version Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Installed Version</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $installedVersion ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Latest Version</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $latestVersion }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full {{ $needsUpgrade ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($needsUpgrade)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        @endif
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p class="text-lg font-bold {{ $needsUpgrade ? 'text-yellow-600' : 'text-green-600' }}">
                        {{ $needsUpgrade ? 'Update Available' : 'Up to Date' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($needsUpgrade)
    <!-- Pending Migrations -->
    @if(count($pendingMigrations) > 0)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Pending Database Migrations</h2>
            <p class="text-sm text-gray-500 mt-1">These migrations will be executed during upgrade</p>
        </div>
        <div class="p-6">
            <ul class="space-y-2">
                @foreach($pendingMigrations as $migration)
                <li class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $migration }}</code>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Changes in New Version -->
    @if(count($changes) > 0)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">What's New</h2>
            <p class="text-sm text-gray-500 mt-1">Changes included in this update</p>
        </div>
        <div class="p-6 space-y-4">
            @foreach($changes as $version => $info)
            <div class="border-l-4 border-blue-500 pl-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Version {{ $version }}</h3>
                    <span class="text-sm text-gray-500">{{ $info['date'] ?? '' }}</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">{{ $info['description'] ?? '' }}</p>
                @if(isset($info['changes']) && count($info['changes']) > 0)
                <ul class="mt-2 space-y-1">
                    @foreach($info['changes'] as $change)
                    <li class="text-sm text-gray-600 flex items-start">
                        <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $change }}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- System Requirements -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">System Requirements</h2>
            <p class="text-sm text-gray-500 mt-1">All requirements must be met before upgrading</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($requirements['requirements'] as $key => $req)
                <div class="flex items-center justify-between p-3 rounded {{ $req['passed'] ? 'bg-green-50' : 'bg-red-50' }}">
                    <div>
                        <p class="font-medium text-sm {{ $req['passed'] ? 'text-green-800' : 'text-red-800' }}">{{ $req['name'] }}</p>
                        <p class="text-xs {{ $req['passed'] ? 'text-green-600' : 'text-red-600' }}">
                            Required: {{ $req['required'] }} | Current: {{ $req['current'] }}
                        </p>
                    </div>
                    <div>
                        @if($req['passed'])
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Upgrade Button -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-semibold text-gray-900">Ready to Upgrade?</h3>
                <p class="text-sm text-gray-500">Make sure to backup your database before proceeding</p>
            </div>
            <div class="flex gap-3">
                <button type="button" id="btn-clear-cache" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Clear Cache
                </button>
                @if($requirements['passed'])
                <button type="button" id="btn-upgrade" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Run Upgrade
                    </span>
                </button>
                @else
                <button type="button" disabled class="px-6 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
                    Requirements Not Met
                </button>
                @endif
            </div>
        </div>

        <!-- Upgrade Progress -->
        <div id="upgrade-progress" class="mt-6 hidden">
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex items-center mb-4">
                    <div id="progress-spinner" class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600 mr-3"></div>
                    <span id="progress-status" class="text-sm font-medium text-gray-700">Starting upgrade...</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div id="progress-output" class="mt-4 p-3 bg-gray-900 rounded text-xs text-green-400 font-mono max-h-48 overflow-y-auto hidden">
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Already Up to Date -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
        <div class="flex items-center">
            <svg class="w-8 h-8 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-semibold text-green-800">Your system is up to date!</h3>
                <p class="text-sm text-green-600">You are running the latest version ({{ $latestVersion }})</p>
            </div>
        </div>

        <div class="mt-4 flex gap-3">
            <button type="button" id="btn-clear-cache" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Clear Cache
            </button>
            <button type="button" id="btn-migrate" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Run Migrations
            </button>
        </div>
    </div>
    @endif

    <!-- Version History -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Version History</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($versionHistory as $version => $info)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-20">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $version === $installedVersion ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            v{{ $version }}
                        </span>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $info['description'] ?? '' }}</p>
                        <p class="text-xs text-gray-500">{{ $info['date'] ?? '' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Clear Cache Button
    const btnClearCache = document.getElementById('btn-clear-cache');
    if (btnClearCache) {
        btnClearCache.addEventListener('click', async function() {
            this.disabled = true;
            this.innerHTML = 'Clearing...';

            try {
                const response = await fetch('{{ route("admin.upgrade.clear-cache") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Cache cleared successfully!');
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                this.disabled = false;
                this.innerHTML = 'Clear Cache';
            }
        });
    }

    // Migrate Button
    const btnMigrate = document.getElementById('btn-migrate');
    if (btnMigrate) {
        btnMigrate.addEventListener('click', async function() {
            if (!confirm('Are you sure you want to run migrations?')) return;

            this.disabled = true;
            this.innerHTML = 'Running...';

            try {
                const response = await fetch('{{ route("admin.upgrade.migrate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Migrations completed successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                this.disabled = false;
                this.innerHTML = 'Run Migrations';
            }
        });
    }

    // Upgrade Button
    const btnUpgrade = document.getElementById('btn-upgrade');
    if (btnUpgrade) {
        btnUpgrade.addEventListener('click', async function() {
            if (!confirm('Are you sure you want to upgrade? Make sure you have backed up your database!')) return;

            this.disabled = true;

            const progressDiv = document.getElementById('upgrade-progress');
            const progressStatus = document.getElementById('progress-status');
            const progressBar = document.getElementById('progress-bar');
            const progressOutput = document.getElementById('progress-output');
            const progressSpinner = document.getElementById('progress-spinner');

            progressDiv.classList.remove('hidden');
            progressOutput.classList.remove('hidden');
            progressOutput.innerHTML = '';

            const addOutput = (text, isError = false) => {
                const line = document.createElement('div');
                line.textContent = '> ' + text;
                if (isError) line.classList.add('text-red-400');
                progressOutput.appendChild(line);
                progressOutput.scrollTop = progressOutput.scrollHeight;
            };

            try {
                addOutput('Starting upgrade process...');
                progressBar.style.width = '10%';
                progressStatus.textContent = 'Clearing caches...';

                const response = await fetch('{{ route("admin.upgrade.run") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const result = await response.json();

                if (result.success) {
                    progressBar.style.width = '100%';
                    progressStatus.textContent = 'Upgrade completed!';
                    progressSpinner.classList.add('hidden');

                    addOutput('Upgrade completed successfully!');
                    addOutput('New version: ' + (result.steps?.update_version?.version || '{{ $latestVersion }}'));

                    if (result.steps?.migrations?.output) {
                        addOutput('Migration output:');
                        addOutput(result.steps.migrations.output);
                    }

                    setTimeout(() => {
                        alert('Upgrade completed successfully!');
                        window.location.reload();
                    }, 1000);
                } else {
                    progressBar.classList.remove('bg-blue-600');
                    progressBar.classList.add('bg-red-600');
                    progressStatus.textContent = 'Upgrade failed!';
                    progressSpinner.classList.add('hidden');

                    addOutput('ERROR: ' + result.message, true);

                    if (result.steps) {
                        Object.entries(result.steps).forEach(([step, data]) => {
                            if (!data.success) {
                                addOutput(`Step "${step}" failed: ${data.message}`, true);
                            }
                        });
                    }
                }
            } catch (error) {
                progressBar.classList.remove('bg-blue-600');
                progressBar.classList.add('bg-red-600');
                progressStatus.textContent = 'Upgrade failed!';
                progressSpinner.classList.add('hidden');

                addOutput('ERROR: ' + error.message, true);
            } finally {
                this.disabled = false;
            }
        });
    }
});
</script>
@endpush
@endsection
