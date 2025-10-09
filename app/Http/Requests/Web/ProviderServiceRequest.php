<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class ProviderServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'provider_id' => 'required|exists:providers,id',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string|max:1000',
            'description.ar' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'provider_id.required' => 'Provider is required.',
            'provider_id.exists' => 'Provider is invalid.',
            'service_id.required' => 'Service is required.',
            'service_id.exists' => 'Service is invalid.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'description.en.required' => 'Description in english is required.',
            'description.ar.required' => 'Description in arabic is required.',
            'description.en.string' => 'Description in english must be a string.',
            'description.ar.string' => 'Description in arabic must be a string.',
            'description.en.max' => 'Description in english cannot exceed 1000 characters.',
            'description.ar.max' => 'Description in arabic cannot exceed 1000 characters.',
            'image.image' => 'Image must be an image.',
            'image.mimes' => 'Image must be a jpeg, png, jpg, or gif.',
            'image.max' => 'Image cannot be larger than 2MB.',
            'is_active.boolean' => 'Is active must be a boolean.',
        ];
    }
}
