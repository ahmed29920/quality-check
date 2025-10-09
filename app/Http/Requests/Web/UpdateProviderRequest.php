<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderRequest extends FormRequest
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
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string|max:1000',
            'description.ar' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'badge_id' => 'nullable|exists:badges,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string|max:500',
            'website_link' => 'nullable|url|max:255',
            'established_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Provider name is required.',
            'name.en.required' => 'English name is required.',
            'name.ar.required' => 'Arabic name is required.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'badge_id.exists' => 'Selected badge does not exist.',
            'latitude.numeric' => 'Latitude must be a number.',
            'latitude.between' => 'Latitude must be between -90 and 90.',
            'longitude.numeric' => 'Longitude must be a number.',
            'longitude.between' => 'Longitude must be between -180 and 180.',
            'website_link.url' => 'Website link must be a valid URL.',
            'established_date.date' => 'Established date must be a valid date.',
            'start_time.date_format' => 'Start time must be in HH:MM format.',
            'end_time.date_format' => 'End time must be in HH:MM format.',
            'end_time.after' => 'End time must be after start time.',
            'image.image' => 'Image must be a valid image file.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'Image cannot be larger than 2MB.',
            'pdf.file' => 'PDF must be a valid file.',
            'pdf.mimes' => 'PDF must be a file of type: pdf.',
            'pdf.max' => 'PDF cannot be larger than 10MB.',
        ];
    }
}
