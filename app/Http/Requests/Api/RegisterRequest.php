<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'role' => 'sometimes|string|in:user,provider',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name cannot exceed 255 characters',

            'phone.required' => 'Phone number is required',
            'phone.string' => 'Phone number must be a string',
            'phone.unique' => 'Phone number is already registered',

            'email.email' => 'Email format is invalid',
            'email.unique' => 'Email is already registered',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',

            'password_confirmation.required' => 'Password confirmation is required',
            'password_confirmation.string' => 'Password confirmation must be a string',
            'password_confirmation.min' => 'Password confirmation must be at least 8 characters',

            'role.in' => 'Role must be either user or provider',
        ];
    }
}
