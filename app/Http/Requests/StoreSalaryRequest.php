<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaryRequest extends FormRequest
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
            'staff_id' => 'required|numeric',
            'amount' => 'required|min:0',
            'date' => 'required|date',
            'month' => 'required|string|max:255',
            'year' => 'required|integer',
            'type' => 'required|string|max:255',
        ];
    }
}
