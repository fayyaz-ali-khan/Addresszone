<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'string', 'max:36'],
            'last_name' => ['sometimes', 'string', 'max:36'],
            'mobile' => ['sometimes', 'string', 'max:12'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,'.$this->user()->id],
            'image' => ['sometimes', 'image', 'max:255'],
            'address' => ['sometimes', 'string', 'max:255'],
            'document_delivery_address' => ['sometimes', 'string', 'max:255'],
            'company_name' => ['sometimes', 'string', 'max:255'],
            'country' => ['sometimes', 'string', 'max:100'],
            'CNIC_Front_Image' => ['sometimes', 'image', 'max:255'],
            'CNIC_Back_Image' => ['sometimes', 'image', 'max:255'],
            // Optional password change via profile
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ];
    }
}
