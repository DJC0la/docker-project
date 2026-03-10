<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'direction_id' => 'required|exists:directions,id',
            'name' => 'required|string|max:255',
            'form' => 'required|string|max:50',
            'duration' => 'required|integer|min:1|max:10',
            'qualification' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean'
        ];
    }
}
