<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password' => [
                'nullable',
                'sometimes',
                'string',
                'min:8',
                Password::min(8)
                ->mixedCase()
                ->numbers()
            ],
            'role' => 'required|in:user,admin',
        ];
    }
}