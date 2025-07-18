<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ini adalah aturan validasi yang sebelumnya ada di controller Anda
        return [
            'product_name' => 'required|string|max:100',
            'list_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // <-- Tambahkan ini

        ];
    }
}