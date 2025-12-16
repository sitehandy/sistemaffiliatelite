<?php

namespace App\Http\Requests\Affiliate;

use App\Models\ProgramEnrollment;
use Illuminate\Foundation\Http\FormRequest;

class EnrollProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'affiliate';
    }

    public function rules(): array
    {
        return [
            'program_id' => [
                'required',
                'exists:programs,id',
                function ($attribute, $value, $fail) {
                    $exists = ProgramEnrollment::where('user_id', $this->user()->id)
                        ->where('program_id', $value)
                        ->whereIn('status', ['pending', 'approved'])
                        ->exists();

                    if ($exists) {
                        $fail('You have already enrolled or pending enrollment in this program.');
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'program_id.required' => 'Program is required.',
            'program_id.exists' => 'Selected program does not exist.',
        ];
    }
}
