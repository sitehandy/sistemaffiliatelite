<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class EnvSettingsController extends Controller
{
    /**
     * Show mail settings form
     */
    public function mailSettings()
    {
        $settings = [
            'mail_mailer' => env('MAIL_MAILER', 'smtp'),
            'mail_host' => env('MAIL_HOST', ''),
            'mail_port' => env('MAIL_PORT', '587'),
            'mail_username' => env('MAIL_USERNAME', ''),
            'mail_password' => env('MAIL_PASSWORD', ''),
            'mail_encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS', ''),
            'mail_from_name' => env('MAIL_FROM_NAME', config('app.name')),
        ];

        return view('admin.settings.mail', compact('settings'));
    }

    /**
     * Update mail settings
     */
    public function updateMailSettings(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer' => ['required', 'string', 'in:smtp,sendmail,mailgun,ses,postmark,log,array'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'string', 'max:10'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'in:tls,ssl,null'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:255'],
        ]);

        $envUpdates = [
            'MAIL_MAILER' => $validated['mail_mailer'],
            'MAIL_HOST' => $validated['mail_host'] ?? '',
            'MAIL_PORT' => $validated['mail_port'] ?? '587',
            'MAIL_USERNAME' => $validated['mail_username'] ?? '',
            'MAIL_PASSWORD' => $validated['mail_password'] ?? '',
            'MAIL_ENCRYPTION' => $validated['mail_encryption'] === 'null' ? 'null' : ($validated['mail_encryption'] ?? 'tls'),
            'MAIL_FROM_ADDRESS' => $validated['mail_from_address'] ?? '',
            'MAIL_FROM_NAME' => $validated['mail_from_name'] ?? config('app.name'),
        ];

        $this->updateEnvFile($envUpdates);

        // Clear config cache
        Artisan::call('config:clear');

        return back()->with('success', 'Mail settings updated successfully. Please test your configuration.');
    }

    /**
     * Test mail configuration
     */
    public function testMail(Request $request)
    {
        $request->validate([
            'test_email' => ['required', 'email'],
        ]);

        try {
            Mail::raw('This is a test email from your affiliate system. If you receive this, your mail configuration is working correctly.', function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('Test Email - Affiliate System');
            });

            return back()->with('success', 'Test email sent successfully to ' . $request->test_email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    /**
     * Show app settings form
     */
    public function appSettings()
    {
        $settings = [
            'app_name' => env('APP_NAME', 'Laravel'),
            'app_env' => env('APP_ENV', 'production'),
            'app_debug' => env('APP_DEBUG', false),
            'app_url' => env('APP_URL', 'http://localhost'),
        ];

        return view('admin.settings.app', compact('settings'));
    }

    /**
     * Update app settings
     */
    public function updateAppSettings(Request $request)
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'app_env' => ['required', 'string', 'in:local,staging,production'],
            'app_debug' => ['required', 'in:true,false'],
            'app_url' => ['required', 'url', 'max:255'],
        ]);

        $envUpdates = [
            'APP_NAME' => $validated['app_name'],
            'APP_ENV' => $validated['app_env'],
            'APP_DEBUG' => $validated['app_debug'],
            'APP_URL' => $validated['app_url'],
        ];

        $this->updateEnvFile($envUpdates);

        // Clear config cache
        Artisan::call('config:clear');

        return back()->with('success', 'Application settings updated successfully.');
    }

    /**
     * Update .env file with new values
     */
    private function updateEnvFile(array $data): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            throw new \Exception('.env file not found');
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            // Handle values with spaces by wrapping in quotes
            $value = $this->formatEnvValue($value);

            // Check if key exists in .env
            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $envContent)) {
                // Key exists, update it
                $envContent = preg_replace($pattern, "{$key}={$value}", $envContent);
            } else {
                // Key doesn't exist, add it
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    /**
     * Format value for .env file
     */
    private function formatEnvValue($value): string
    {
        if ($value === null || $value === '') {
            return '""';
        }

        // If value contains spaces, quotes, or special characters, wrap in quotes
        if (preg_match('/\s|"|\'|#/', $value) || $value === 'null') {
            // Escape any existing quotes
            $value = str_replace('"', '\"', $value);
            return '"' . $value . '"';
        }

        return $value;
    }
}
