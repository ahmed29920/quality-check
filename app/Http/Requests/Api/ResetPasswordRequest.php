<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email',
            'code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            
            'code.required' => 'Reset code is required',
            'code.string' => 'Reset code must be a string',
            'code.size' => 'Reset code must be 6 digits',
            
            'password.required' => 'New password is required',
            'password.string' => 'New password must be a string',
            'password.min' => 'New password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            
            'password_confirmation.required' => 'Password confirmation is required',
            'password_confirmation.string' => 'Password confirmation must be a string',
            'password_confirmation.min' => 'Password confirmation must be at least 8 characters',
        ];
    }
}
