<?php

namespace App\Http\Requests\Affiliate;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'affiliate';
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:paypal,bank_transfer,wise,crypto'],
            'details' => ['required', 'array'],
            'details.email' => ['required_if:type,paypal,wise', 'nullable', 'email', 'max:255'],
            'details.bank_name' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:255'],
            'details.account_name' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:255'],
            'details.account_number' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:50'],
            'details.routing_number' => ['nullable', 'string', 'max:50'],
            'details.swift_code' => ['nullable', 'string', 'max:20'],
            'details.wallet_address' => ['required_if:type,crypto', 'nullable', 'string', 'max:255'],
            'details.crypto_network' => ['required_if:type,crypto', 'nullable', 'string', 'max:50'],
            'is_primary' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Please select a payment method type.',
            'type.in' => 'Invalid payment method type selected.',
            'details.required' => 'Payment details are required.',
            'details.email.required_if' => 'Email is required for PayPal/Wise.',
            'details.email.email' => 'Please enter a valid email address.',
            'details.bank_name.required_if' => 'Bank name is required for bank transfers.',
            'details.account_name.required_if' => 'Account name is required for bank transfers.',
            'details.account_number.required_if' => 'Account number is required for bank transfers.',
            'details.wallet_address.required_if' => 'Wallet address is required for crypto payments.',
            'details.crypto_network.required_if' => 'Crypto network is required for crypto payments.',
        ];
    }
}
