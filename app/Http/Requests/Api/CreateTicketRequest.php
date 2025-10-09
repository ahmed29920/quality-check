<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}
