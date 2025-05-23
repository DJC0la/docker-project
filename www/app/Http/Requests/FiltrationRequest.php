<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiltrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'perPage' => 'integer|min:1|max:100',
            'search_name' => 'nullable|string|max:255',
            'search_email' => 'nullable|string|max:255',
            'search_direction' => 'nullable|string|max:255',
            'search_code' => 'nullable|string|max:255',
        ];
    }
}
