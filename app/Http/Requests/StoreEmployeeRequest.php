<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email',
            'phone'        => 'required|string|min:7|max:16|unique:users,phone',
            'nid'          => 'required|string|max:255|unique:users,nid',
            'address'      => 'required|string',
            'file'         => 'nullable|mimes:png,jpg,pdf',
        ];
    }
}
