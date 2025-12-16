<?php

namespace App\Http\Requests\Affiliate;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class StorePayoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'affiliate';
    }

    public function rules(): array
    {
        return [
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
                function ($attribute, $value, $fail) {
                    $exists = PaymentMethod::where('id', $value)
                        ->where('user_id', $this->user()->id)
                        ->where('is_active', true)
                        ->exists();

                    if (!$exists) {
                        $fail('Selected payment method is not valid.');
                    }
                },
            ],
            'amount' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method_id.required' => 'Please select a payment method.',
            'payment_method_id.exists' => 'Selected payment method does not exist.',
            'amount.min' => 'Amount must be a positive value.',
        ];
    }
}
