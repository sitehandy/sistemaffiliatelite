<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'program_id' => ['required', 'exists:programs,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0', 'max:1000000'],
            'commission_override' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'url' => ['required', 'url', 'max:500'],
            'image' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,webp'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'program_id.required' => 'Please select a program.',
            'program_id.exists' => 'Selected program does not exist.',
            'name.required' => 'Product name is required.',
            'sku.unique' => 'This SKU is already in use.',
            'price.required' => 'Product price is required.',
            'price.min' => 'Price cannot be negative.',
            'url.required' => 'Product URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size must not exceed 2MB.',
        ];
    }
}
