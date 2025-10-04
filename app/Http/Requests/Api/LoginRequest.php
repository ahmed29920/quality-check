<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/',
            'password' => 'required|string',
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
            
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
        ];
    }
}
