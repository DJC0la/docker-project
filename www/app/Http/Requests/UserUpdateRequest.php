<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => [
                'nullable',
                'sometimes',
                'string',
                'min:8',
                Password::min(8)
                ->mixedCase()
                ->numbers()
            ],
            'role' => 'required|in:user,admin'
        ];
    }
}