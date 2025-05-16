<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'rector_id' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
        ];
    }
}
