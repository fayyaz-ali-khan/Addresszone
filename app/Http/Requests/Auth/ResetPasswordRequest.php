<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules= [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($this->is('api/*')) {
            $rules['otp'] = ['required'];
        } else {
            $rules['token'] = ['required', 'string'];
        }
        return $rules;
    }
}
