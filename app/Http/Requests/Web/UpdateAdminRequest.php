<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $admin = $this->route('admin');
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin,
            'phone' => 'required|string|unique:users,phone,' . $admin,
            'password' => 'nullable|string|min:6',
            'assigned_role' => 'required|string|exists:roles,name',
            'image' => 'nullable|file|max:5100',
        ];
    }
}
