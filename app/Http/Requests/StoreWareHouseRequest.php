<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWareHouseRequest extends FormRequest
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
            'warehouse_name' => 'required|string|max:255|unique:ware_houses,warehouse_name',
            'warehouse_address' => 'required|string',
            'warehouse_zipcode' => 'required|string|min:4',
            'warehouse_phone' => 'required|string|min:7|max:15',
        ];
    }
}
