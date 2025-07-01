<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSystemSettingRequest extends FormRequest
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
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'required|string|max:255',
            'site_email' => 'required|string|email|max:255',
            'site_phone' => 'required|string|min:7|max:15',
            'site_facebook_link' => 'required|string|url|max:255',
            'site_address' => 'required|string',
            'meta_keywords' => 'required|string',
            'meta_description' => 'required|string',
            'meta_author' => 'required|string|max:255',
        ];
    }
}
