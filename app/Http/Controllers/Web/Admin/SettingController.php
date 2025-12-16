<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'min_payout_amount' => ['required', 'numeric', 'min:0'],
            'default_cookie_duration' => ['required', 'integer', 'min:1'],
            'auto_approve_enrollments' => ['boolean'],
            'auto_approve_commissions' => ['boolean'],
            'payout_schedule' => ['required', 'in:weekly,biweekly,monthly'],
        ]);

        $settings = [
            ['key' => 'site_name', 'value' => $validated['site_name'], 'type' => 'string', 'is_public' => true],
            ['key' => 'min_payout_amount', 'value' => $validated['min_payout_amount'], 'type' => 'integer', 'is_public' => true],
            ['key' => 'default_cookie_duration', 'value' => $validated['default_cookie_duration'], 'type' => 'integer', 'is_public' => true],
            ['key' => 'auto_approve_enrollments', 'value' => $validated['auto_approve_enrollments'] ?? false ? '1' : '0', 'type' => 'boolean', 'is_public' => false],
            ['key' => 'auto_approve_commissions', 'value' => $validated['auto_approve_commissions'] ?? false ? '1' : '0', 'type' => 'boolean', 'is_public' => false],
            ['key' => 'payout_schedule', 'value' => $validated['payout_schedule'], 'type' => 'string', 'is_public' => false],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'is_public' => $setting['is_public'],
                ]
            );
        }

        // Clear cache
        cache()->forget('system_settings');

        return back()->with('success', 'Settings updated successfully.');
    }
}
