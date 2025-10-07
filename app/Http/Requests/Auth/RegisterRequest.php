<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'   => ['required', 'string', 'max:24'],
            'last_name'    => ['required', 'string', 'max:24'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'mobile'       => ['required', 'max:12'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'address'      => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'country'      => ['required']
        ];
    }
}
