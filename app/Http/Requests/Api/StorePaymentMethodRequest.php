<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:paypal,bank_transfer,wise,crypto'],
            'details' => ['required', 'array'],
            'is_primary' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Payment method type is required.',
            'type.in' => 'Invalid payment method type.',
            'details.required' => 'Payment details are required.',
            'details.array' => 'Payment details must be an object.',
        ];
    }
}
