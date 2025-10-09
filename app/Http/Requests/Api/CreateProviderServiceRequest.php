<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateProviderServiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'service_id'     => 'required|exists:services,id',
            'description'    => 'required|array',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
            'price'          => 'sometimes|numeric',
            'image'          => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'service_id.required' => 'The service id is required.',
            'service_id.exists' => 'The service id is invalid.',
            'description.en.required' => 'The description in english is required.',
            'description.ar.required' => 'The description in arabic is required.',
            'price.numeric' => 'The price must be a number.',
            'image.image' => 'The image must be an image.',
            'image.mimes' => 'The image must be a jpeg, png, jpg, gif, or svg.',
            'image.max' => 'The image must be less than 2048kb.',
        ];
    }
}
