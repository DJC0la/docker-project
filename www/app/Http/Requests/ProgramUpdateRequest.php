<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'direction_id' => 'sometimes|required|exists:directions,id',
            'name' => 'sometimes|required|string|max:255',
            'form' => 'sometimes|required|string|max:50',
            'duration' => 'sometimes|required|integer|min:1|max:10',
            'qualification' => 'sometimes|required|string|max:255',
            'is_active' => 'sometimes|boolean'
        ];
    }
}
