<?php

namespace App\Http\Requests\Api;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class StorePayoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
                function ($attribute, $value, $fail) {
                    if (!$this->user()) {
                        return;
                    }

                    $exists = PaymentMethod::where('id', $value)
                        ->where('user_id', $this->user()->id)
                        ->where('is_active', true)
                        ->exists();

                    if (!$exists) {
                        $fail('Invalid payment method.');
                    }
                },
            ],
            'amount' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method_id.required' => 'Payment method ID is required.',
            'payment_method_id.exists' => 'Payment method not found.',
            'amount.min' => 'Amount must be positive.',
        ];
    }
}
