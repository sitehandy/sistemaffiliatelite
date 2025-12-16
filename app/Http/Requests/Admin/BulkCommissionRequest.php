<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'commission_ids' => ['required', 'array', 'min:1'],
            'commission_ids.*' => ['required', 'integer', 'exists:commissions,id'],
            'action' => ['required', 'in:approve,reject'],
        ];
    }

    public function messages(): array
    {
        return [
            'commission_ids.required' => 'Please select at least one commission.',
            'commission_ids.min' => 'Please select at least one commission.',
            'commission_ids.*.exists' => 'One or more selected commissions do not exist.',
            'action.required' => 'Please select an action.',
            'action.in' => 'Invalid action selected.',
        ];
    }
}
