<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPhoneRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string',
            'code' => 'required|string|size:6',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'phone.required' => 'Phone number is required',
            'phone.string' => 'Phone number must be a string',
            'phone.regex' => 'Phone number format is invalid',
            
            'code.required' => 'Verification code is required',
            'code.string' => 'Verification code must be a string',
            'code.size' => 'Verification code must be 6 digits',
        ];
    }
}
