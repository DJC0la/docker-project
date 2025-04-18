<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePasswordRequest extends FormRequest
{
    protected $errorBag = 'updatePassword';
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required', 
                'confirmed',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(
            back()
                ->withErrors($validator, 'updatePassword')
                ->withInput()
        ));
    }
}