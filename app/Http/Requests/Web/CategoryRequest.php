<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            // Category validation
            'name' => 'required|array',
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',

            'description' => 'nullable|array',
            'description.ar' => 'nullable|string|max:1000',
            'description.en' => 'nullable|string|max:1000',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'has_pricable_services' => 'boolean',
            'monthly_subscription_price' => 'nullable|numeric|min:0',
            'yearly_subscription_price' => 'nullable|numeric|min:0',

            // MCQ Questions validation
            'questions' => 'nullable|array',
            'questions.*.title' => 'required_with:questions|string|max:255',
            'questions.*.options' => 'required_with:questions|array|min:2|max:10',
            'questions.*.options.*' => 'required_with:questions.*.options|string|max:255',
            'questions.*.score' => 'required_with:questions|integer|min:1|max:100',
            'questions.*.allows_attachments' => 'boolean',
            'questions.*.requires_attachment' => 'boolean',
            'questions.*.is_active' => 'boolean',
            'questions.*.sort_order' => 'integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Category messages
            'name.required' => 'Category name is required.',
            'name.max' => 'Category name must not exceed 255 characters.',
            'description.max' => 'Category description must not exceed 1000 characters.',
            'image.image' => 'File must be an image.',
            'image.mimes' => 'Image must be jpeg, png, jpg, or gif format.',
            'image.max' => 'Image size must not exceed 2MB.',

            // Questions messages
            'questions.*.title.required_with' => 'Question title is required.',
            'questions.*.title.max' => 'Question title must not exceed 255 characters.',
            'questions.*.options.required_with' => 'At least 2 answer options are required.',
            'questions.*.options.min' => 'At least 2 answer options are required.',
            'questions.*.options.max' => 'Maximum 10 answer options allowed.',
            'questions.*.options.*.required_with' => 'Each answer option is required.',
            'questions.*.options.*.max' => 'Answer options must not exceed 255 characters.',
            'questions.*.score.required_with' => 'Score is required.',
            'questions.*.score.min' => 'Score must be at least 1.',
            'questions.*.score.max' => 'Score must not exceed 100.',
        ];
    }
}
