<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TrackClickRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tracking_code' => ['required', 'string'],
            'ip_address' => ['nullable', 'ip'],
            'user_agent' => ['nullable', 'string', 'max:500'],
            'referer' => ['nullable', 'url', 'max:500'],
            'landing_page' => ['nullable', 'url', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'tracking_code.required' => 'Tracking code is required.',
            'ip_address.ip' => 'Invalid IP address format.',
            'referer.url' => 'Invalid referer URL format.',
            'landing_page.url' => 'Invalid landing page URL format.',
        ];
    }
}
