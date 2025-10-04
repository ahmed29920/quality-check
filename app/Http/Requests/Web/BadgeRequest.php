<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class BadgeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|array',
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'min_score' => 'required|integer|min:0|max:100',
            'max_score' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ];
    }
}
