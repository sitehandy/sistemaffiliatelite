<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:approved,rejected'],
            'rejection_reason' => ['required_if:status,rejected', 'nullable', 'string', 'max:1000'],
            'custom_commission_type' => ['nullable', 'in:percentage,fixed'],
            'custom_commission_value' => ['nullable', 'numeric', 'min:0', 'max:100000'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'rejection_reason.required_if' => 'Please provide a reason for rejection.',
        ];
    }
}
