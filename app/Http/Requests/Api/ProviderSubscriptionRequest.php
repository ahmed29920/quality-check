<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProviderSubscriptionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|in:monthly,yearly',
        ];
    }
}
