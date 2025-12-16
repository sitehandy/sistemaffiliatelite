<?php

namespace App\Services\Installation;

use App\Models\InstallationLog;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class InstallationService
{
    private RequirementChecker $requirementChecker;

    public function __construct(RequirementChecker $requirementChecker)
    {
        $this->requirementChecker = $requirementChecker;
    }

    public function isInstalled(): bool
    {
        return file_exists(storage_path('installed'));
    }

    public function checkRequirements(): array
    {
        $this->log('requirements', 'pending', 'Checking server requirements...');

        $results = $this->requirementChecker->check();
        $passed = $this->requirementChecker->allPassed();

        if ($passed) {
            $this->log('requirements', 'completed', 'All requirements passed');
        } else {
            $this->log('requirements', 'failed', 'Some requirements not met', $results);
        }

        return [
            'passed' => $passed,
            'results' => $results,
        ];
    }

    public function testDatabaseConnection(array $config): array
    {
        $this->log('database', 'pending', 'Testing database connection...');

        try {
            Config::set('database.connections.test_mysql', [
                'driver' => 'mysql',
                'host' => $config['host'],
                'port' => $config['port'] ?? 3306,
                'database' => $config['database'],
                'username' => $config['username'],
                'password' => $config['password'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ]);

            DB::connection('test_mysql')->getPdo();

            $this->log('database', 'completed', 'Database connection successful');

            return [
                'success' => true,
                'message' => 'Database connection successful',
            ];
        } catch (\Exception $e) {
            $this->log('database', 'failed', 'Database connection failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Database connection failed: ' . $e->getMessage(),
            ];
        }
    }

    public function saveEnvironment(array $config): array
    {
        $this->log('environment', 'pending', 'Saving environment configuration...');

        try {
            $envPath = base_path('.env');
            $envContent = file_get_contents($envPath);

            $replacements = [
                'APP_NAME' => '"' . addslashes($config['app_name']) . '"',
                'APP_URL' => $config['app_url'],
                'DB_HOST' => $config['db_host'],
                'DB_PORT' => $config['db_port'] ?? '3306',
                'DB_DATABASE' => $config['db_database'],
                'DB_USERNAME' => $config['db_username'],
                'DB_PASSWORD' => $config['db_password'],
            ];

            if (!empty($config['mail_host'])) {
                $replacements = array_merge($replacements, [
                    'MAIL_MAILER' => 'smtp',
                    'MAIL_HOST' => $config['mail_host'],
                    'MAIL_PORT' => $config['mail_port'] ?? '587',
                    'MAIL_USERNAME' => $config['mail_username'] ?? '',
                    'MAIL_PASSWORD' => $config['mail_password'] ?? '',
                    'MAIL_ENCRYPTION' => $config['mail_encryption'] ?? 'tls',
                    'MAIL_FROM_ADDRESS' => $config['mail_from_address'] ?? '',
                    'MAIL_FROM_NAME' => '"' . addslashes($config['app_name']) . '"',
                ]);
            }

            foreach ($replacements as $key => $value) {
                $pattern = "/^{$key}=.*/m";
                $replacement = "{$key}={$value}";

                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $replacement, $envContent);
                } else {
                    $envContent .= "\n{$replacement}";
                }
            }

            file_put_contents($envPath, $envContent);

            $this->log('environment', 'completed', 'Environment configuration saved');

            return [
                'success' => true,
                'message' => 'Environment configuration saved',
            ];
        } catch (\Exception $e) {
            $this->log('environment', 'failed', 'Failed to save environment', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Failed to save environment: ' . $e->getMessage(),
            ];
        }
    }

    public function runMigrations(): array
    {
        $this->log('migrations', 'pending', 'Running database migrations...');

        try {
            Artisan::call('migrate', ['--force' => true]);

            $this->log('migrations', 'completed', 'Database migrations completed');

            return [
                'success' => true,
                'message' => 'Database migrations completed',
                'output' => Artisan::output(),
            ];
        } catch (\Exception $e) {
            $this->log('migrations', 'failed', 'Migration failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage(),
            ];
        }
    }

    public function seedDatabase(): array
    {
        $this->log('seeding', 'pending', 'Seeding database...');

        try {
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);

            $this->log('seeding', 'completed', 'Database seeding completed');

            return [
                'success' => true,
                'message' => 'Database seeding completed',
            ];
        } catch (\Exception $e) {
            $this->log('seeding', 'failed', 'Seeding failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Seeding failed: ' . $e->getMessage(),
            ];
        }
    }

    public function createAdminUser(array $data): array
    {
        $this->log('admin', 'pending', 'Creating admin account...');

        try {
            $adminRole = Role::where('name', 'admin')->first();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $adminRole?->id,
                'email_verified_at' => now(),
            ]);

            $this->log('admin', 'completed', 'Admin account created');

            return [
                'success' => true,
                'message' => 'Admin account created',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                ],
            ];
        } catch (\Exception $e) {
            $this->log('admin', 'failed', 'Failed to create admin', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Failed to create admin account: ' . $e->getMessage(),
            ];
        }
    }

    public function testEmailConfiguration(): array
    {
        $this->log('email', 'pending', 'Testing email configuration...');

        try {
            // Try to send a test email
            Mail::raw('This is a test email from the Affiliate Management System installer.', function ($message) {
                $message->to(config('mail.from.address'))
                    ->subject('Installation Test Email');
            });

            $this->log('email', 'completed', 'Email configuration working');

            return [
                'success' => true,
                'message' => 'Email configuration working',
            ];
        } catch (\Exception $e) {
            $this->log('email', 'failed', 'Email test failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Email test failed: ' . $e->getMessage(),
            ];
        }
    }

    public function initializeSettings(): array
    {
        $this->log('settings', 'pending', 'Initializing system settings...');

        try {
            $defaultSettings = [
                ['key' => 'site_name', 'value' => config('app.name'), 'type' => 'string', 'is_public' => true],
                ['key' => 'min_payout_amount', 'value' => '50', 'type' => 'integer', 'is_public' => true],
                ['key' => 'default_cookie_duration', 'value' => '30', 'type' => 'integer', 'is_public' => true],
                ['key' => 'auto_approve_enrollments', 'value' => '0', 'type' => 'boolean', 'is_public' => false],
                ['key' => 'auto_approve_commissions', 'value' => '0', 'type' => 'boolean', 'is_public' => false],
                ['key' => 'payout_schedule', 'value' => 'monthly', 'type' => 'string', 'is_public' => false],
            ];

            foreach ($defaultSettings as $setting) {
                SystemSetting::updateOrCreate(
                    ['key' => $setting['key']],
                    [
                        'value' => $setting['value'],
                        'type' => $setting['type'],
                        'is_public' => $setting['is_public'],
                    ]
                );
            }

            $this->log('settings', 'completed', 'System settings initialized');

            return [
                'success' => true,
                'message' => 'System settings initialized',
            ];
        } catch (\Exception $e) {
            $this->log('settings', 'failed', 'Failed to initialize settings', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Failed to initialize settings: ' . $e->getMessage(),
            ];
        }
    }

    public function finalize(): array
    {
        $this->log('finalize', 'pending', 'Finalizing installation...');

        try {
            // Generate app key if not set
            if (empty(config('app.key'))) {
                Artisan::call('key:generate', ['--force' => true]);
            }

            // Create storage link
            if (!file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
            }

            // Switch to database session/cache now that tables exist
            $this->updateEnvValue('SESSION_DRIVER', 'database');
            $this->updateEnvValue('CACHE_STORE', 'database');

            // Optimize application
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            // Mark as installed
            file_put_contents(storage_path('installed'), date('Y-m-d H:i:s'));

            $this->log('finalize', 'completed', 'Installation completed successfully');

            return [
                'success' => true,
                'message' => 'Installation completed successfully',
            ];
        } catch (\Exception $e) {
            $this->log('finalize', 'failed', 'Finalization failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Finalization failed: ' . $e->getMessage(),
            ];
        }
    }

    private function updateEnvValue(string $key, string $value): void
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        $pattern = "/^{$key}=.*/m";
        $replacement = "{$key}={$value}";

        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, $replacement, $envContent);
        } else {
            $envContent .= "\n{$replacement}";
        }

        file_put_contents($envPath, $envContent);
    }

    private function log(string $step, string $status, string $message, ?array $details = null): void
    {
        try {
            InstallationLog::create([
                'step' => $step,
                'status' => $status,
                'message' => $message,
                'details' => $details,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log to file if database not available
            logger()->error("Installation [{$step}]: {$message}", $details ?? []);
        }
    }
}
