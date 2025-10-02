<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class McqQuestionRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:10',
            'options.*' => 'required|string|max:255',
            'allows_attachments' => 'boolean',
            'requires_attachment' => 'boolean',
            'score' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'title.required' => 'Question title is required.',
            'title.max' => 'Question title must not exceed 255 characters.',
            'options.required' => 'At least 2 answer options are required.',
            'options.min' => 'At least 2 answer options are required.',
            'options.max' => 'Maximum 10 answer options allowed.',
            'options.*.required' => 'Each answer option is required.',
            'options.*.max' => 'Answer options must not exceed 255 characters.',
            'score.required' => 'Score is required.',
            'score.min' => 'Score must be at least 1.',
            'score.max' => 'Score must not exceed 100.',
            'sort_order.min' => 'Sort order must be 0 or greater.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean up options array
        if ($this->has('options')) {
            $options = array_values(array_filter($this->options, function($option) {
                return !empty(trim($option));
            }));
            $this->merge(['options' => $options]);
        }
    }
}
