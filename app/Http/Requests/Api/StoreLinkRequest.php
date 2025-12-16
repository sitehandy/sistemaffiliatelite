<?php

namespace App\Http\Requests\Api;

use App\Models\ProgramEnrollment;
use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'program_id' => [
                'required',
                'exists:programs,id',
                function ($attribute, $value, $fail) {
                    if (!$this->user()) {
                        return;
                    }

                    $enrolled = ProgramEnrollment::where('user_id', $this->user()->id)
                        ->where('program_id', $value)
                        ->where('status', 'approved')
                        ->exists();

                    if (!$enrolled) {
                        $fail('You must be enrolled in this program to create links.');
                    }
                },
            ],
            'product_id' => ['nullable', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'destination_url' => ['nullable', 'url', 'max:500'],
            'campaign' => ['nullable', 'string', 'max:100', 'alpha_dash'],
        ];
    }

    public function messages(): array
    {
        return [
            'program_id.required' => 'Program ID is required.',
            'program_id.exists' => 'Program not found.',
            'product_id.exists' => 'Product not found.',
            'name.required' => 'Link name is required.',
            'destination_url.url' => 'Invalid destination URL.',
            'campaign.alpha_dash' => 'Campaign may only contain letters, numbers, dashes and underscores.',
        ];
    }
}
