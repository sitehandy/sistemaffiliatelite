<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreConversionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tracking_code' => ['required', 'string', 'exists:tracking_links,code'],
            'order_id' => ['required', 'string', 'max:255', 'unique:conversions,order_id'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:1000000'],
            'currency' => ['nullable', 'string', 'size:3'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_id' => ['nullable', 'string', 'max:255'],
            'product_name' => ['nullable', 'string', 'max:255'],
            'metadata' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'tracking_code.required' => 'Tracking code is required.',
            'tracking_code.exists' => 'Invalid tracking code.',
            'order_id.required' => 'Order ID is required.',
            'order_id.unique' => 'This order has already been recorded.',
            'amount.required' => 'Amount is required.',
            'amount.min' => 'Amount must be greater than zero.',
            'currency.size' => 'Currency must be a 3-letter ISO code.',
            'customer_email.email' => 'Invalid email format.',
        ];
    }
}
