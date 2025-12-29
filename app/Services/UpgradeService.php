<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class UpgradeService
{
    /**
     * Get current installed version from database
     */
    public function getInstalledVersion(): ?string
    {
        try {
            if (!Schema::hasTable('system_settings')) {
                return null;
            }

            $setting = DB::table('system_settings')
                ->where('key', 'app_version')
                ->first();

            return $setting?->value ?? '1.0.0';
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get latest version from config
     */
    public function getLatestVersion(): string
    {
        return config('version.current', '1.0.0');
    }

    /**
     * Check if upgrade is needed
     */
    public function needsUpgrade(): bool
    {
        $installed = $this->getInstalledVersion();
        $latest = $this->getLatestVersion();

        if (!$installed) {
            return false; // Not installed yet
        }

        return version_compare($installed, $latest, '<');
    }

    /**
     * Get pending migrations
     */
    public function getPendingMigrations(): array
    {
        try {
            // Get all migration files
            $migrationPath = database_path('migrations');
            $files = File::glob($migrationPath . '/*.php');

            $allMigrations = [];
            foreach ($files as $file) {
                $allMigrations[] = pathinfo($file, PATHINFO_FILENAME);
            }

            // Get ran migrations from database
            if (!Schema::hasTable('migrations')) {
                return $allMigrations;
            }

            $ranMigrations = DB::table('migrations')
                ->pluck('migration')
                ->toArray();

            // Return pending migrations
            return array_values(array_diff($allMigrations, $ranMigrations));
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Run pending migrations
     */
    public function runMigrations(): array
    {
        try {
            // Clear config cache first
            Artisan::call('config:clear');

            // Run migrations
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            return [
                'success' => true,
                'message' => 'Migrations completed successfully',
                'output' => $output,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage(),
                'output' => $e->getTraceAsString(),
            ];
        }
    }

    /**
     * Clear all caches
     */
    public function clearCaches(): array
    {
        try {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            // Try to clear opcache if available
            if (function_exists('opcache_reset')) {
                opcache_reset();
            }

            return [
                'success' => true,
                'message' => 'All caches cleared successfully',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Cache clear failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update version in database
     */
    public function updateVersion(): array
    {
        try {
            $newVersion = $this->getLatestVersion();

            DB::table('system_settings')->updateOrInsert(
                ['key' => 'app_version'],
                [
                    'value' => $newVersion,
                    'type' => 'string',
                    'is_public' => true,
                    'updated_at' => now(),
                ]
            );

            return [
                'success' => true,
                'message' => "Version updated to {$newVersion}",
                'version' => $newVersion,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Version update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Run full upgrade process
     */
    public function runUpgrade(): array
    {
        $steps = [];

        // Step 1: Clear caches
        $steps['clear_cache'] = $this->clearCaches();
        if (!$steps['clear_cache']['success']) {
            // Continue anyway, cache clear failure is not critical
        }

        // Step 2: Run migrations
        $steps['migrations'] = $this->runMigrations();
        if (!$steps['migrations']['success']) {
            return [
                'success' => false,
                'message' => 'Upgrade failed at migrations step',
                'steps' => $steps,
            ];
        }

        // Step 3: Update version
        $steps['update_version'] = $this->updateVersion();
        if (!$steps['update_version']['success']) {
            return [
                'success' => false,
                'message' => 'Upgrade completed but version update failed',
                'steps' => $steps,
            ];
        }

        // Step 4: Clear caches again
        $steps['final_cache_clear'] = $this->clearCaches();

        return [
            'success' => true,
            'message' => 'Upgrade completed successfully to version ' . $this->getLatestVersion(),
            'steps' => $steps,
        ];
    }

    /**
     * Get version history
     */
    public function getVersionHistory(): array
    {
        return config('version.history', []);
    }

    /**
     * Get changes since installed version
     */
    public function getChangesSinceInstalled(): array
    {
        $installed = $this->getInstalledVersion() ?? '0.0.0';
        $history = $this->getVersionHistory();
        $changes = [];

        foreach ($history as $version => $info) {
            if (version_compare($version, $installed, '>')) {
                $changes[$version] = $info;
            }
        }

        return $changes;
    }

    /**
     * Check system requirements for upgrade
     */
    public function checkRequirements(): array
    {
        $requirements = [];

        // PHP Version
        $minPhp = config('version.minimum_php', '8.2.0');
        $requirements['php'] = [
            'name' => 'PHP Version',
            'required' => $minPhp,
            'current' => PHP_VERSION,
            'passed' => version_compare(PHP_VERSION, $minPhp, '>='),
        ];

        // Required Extensions
        $extensions = config('version.required_extensions', []);
        foreach ($extensions as $ext) {
            $requirements["ext_{$ext}"] = [
                'name' => "PHP Extension: {$ext}",
                'required' => 'Installed',
                'current' => extension_loaded($ext) ? 'Installed' : 'Not installed',
                'passed' => extension_loaded($ext),
            ];
        }

        // Writable directories
        $writableDirs = [
            'storage' => storage_path(),
            'bootstrap/cache' => base_path('bootstrap/cache'),
        ];

        foreach ($writableDirs as $name => $path) {
            $requirements["writable_{$name}"] = [
                'name' => "Writable: {$name}",
                'required' => 'Writable',
                'current' => is_writable($path) ? 'Writable' : 'Not writable',
                'passed' => is_writable($path),
            ];
        }

        $allPassed = collect($requirements)->every(fn($r) => $r['passed']);

        return [
            'passed' => $allPassed,
            'requirements' => $requirements,
        ];
    }
}
