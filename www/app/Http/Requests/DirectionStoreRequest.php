<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectionStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'organization_id' => 'required|exists:organizations,id',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'degree' => 'required|in:secondary_special,bachelor,specialist,master,postgraduate',
        ];
    }
}
