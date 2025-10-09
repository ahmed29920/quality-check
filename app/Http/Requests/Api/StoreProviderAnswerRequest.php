<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreProviderAnswerRequest extends FormRequest
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
            'question_id' => 'required|exists:mcq_questions,id',
            'answer'      => 'required|string|max:5000',
            'attachment'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'question_id.required' => 'Question ID is required.',
            'question_id.exists'   => 'The selected question does not exist.',
            'answer.required'      => 'Answer is required.',
            'answer.string'        => 'Answer must be a string.',
            'answer.max'           => 'Answer cannot exceed 5000 characters.',
            'attachment.file'      => 'Attachment must be a file.',
            'attachment.mimes'     => 'Attachment must be a file of type: pdf, doc, docx, jpg, jpeg, png.',
            'attachment.max'       => 'Attachment cannot be larger than 10MB.',
        ];
    }
}
