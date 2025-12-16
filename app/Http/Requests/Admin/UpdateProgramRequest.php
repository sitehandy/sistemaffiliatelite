<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('programs', 'slug')->ignore($this->route('program')),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'commission_type' => ['required', 'in:percentage,fixed'],
            'commission_value' => ['required', 'numeric', 'min:0', 'max:100000'],
            'cookie_duration' => ['required', 'integer', 'min:1', 'max:365'],
            'min_payout' => ['required', 'numeric', 'min:0', 'max:100000'],
            'terms' => ['nullable', 'string', 'max:10000'],
            'is_active' => ['boolean'],
            'requires_approval' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Program name is required.',
            'slug.unique' => 'This slug is already taken.',
            'slug.alpha_dash' => 'Slug may only contain letters, numbers, dashes and underscores.',
            'commission_value.required' => 'Commission value is required.',
            'cookie_duration.required' => 'Cookie duration is required.',
        ];
    }
}
