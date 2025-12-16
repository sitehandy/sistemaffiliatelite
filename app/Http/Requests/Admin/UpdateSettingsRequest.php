<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:255'],
            'site_url' => ['required', 'url', 'max:500'],
            'support_email' => ['required', 'email', 'max:255'],
            'default_commission_type' => ['required', 'in:percentage,fixed'],
            'default_commission_value' => ['required', 'numeric', 'min:0', 'max:100000'],
            'default_cookie_duration' => ['required', 'integer', 'min:1', 'max:365'],
            'default_min_payout' => ['required', 'numeric', 'min:0', 'max:100000'],
            'payout_schedule' => ['required', 'in:weekly,biweekly,monthly'],
            'require_enrollment_approval' => ['boolean'],
            'require_commission_approval' => ['boolean'],
            'auto_approve_returning' => ['boolean'],
            'fraud_detection_enabled' => ['boolean'],
            'fraud_click_threshold' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'fraud_conversion_threshold' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'site_name.required' => 'Site name is required.',
            'site_url.required' => 'Site URL is required.',
            'site_url.url' => 'Please enter a valid URL.',
            'support_email.required' => 'Support email is required.',
            'support_email.email' => 'Please enter a valid email address.',
            'default_commission_value.required' => 'Default commission value is required.',
            'default_cookie_duration.required' => 'Default cookie duration is required.',
            'default_min_payout.required' => 'Default minimum payout is required.',
            'payout_schedule.required' => 'Payout schedule is required.',
        ];
    }
}
