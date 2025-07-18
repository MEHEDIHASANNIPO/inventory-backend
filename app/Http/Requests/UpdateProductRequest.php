<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        return [
            'category_id' => 'required|numeric|exists:categories,id',
            'brand_id' => 'required|numeric|exists:brands,id',
            'supplier_id' => 'required|numeric|exists:users,id',
            'warehouse_id' => 'required|numeric|exists:ware_houses,id',
            'product_name' => 'required|string|max:255',
            'original_price' => 'required|min:0',
            'sell_price' => 'required|min:0',
            'stock' => 'required|min:0',
            'description' => 'required|string',
            'file' => 'nullable|mimes:png,jpg'
        ];
    }
}
