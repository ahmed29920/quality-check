<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|string',
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
            'current_password.required' => 'Current password is required',
            'current_password.string' => 'Current password must be a string',
            
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
