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
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'image' => ['nullable', 'image', 'mimes:png,jpg'],
            'address' => ['sometimes', 'string', 'max:255'],
            'document_delivery_address' => ['sometimes', 'string', 'max:255'],
            'company_name' => ['sometimes', 'string', 'max:255'],
            'country' => ['sometimes', 'string', 'max:100'],
            'CNIC_Front_Image' => ['nullable', 'image', 'mimes:png,jpg'],
            'CNIC_Back_Image' => ['nullable', 'image', 'mimes:png,jpg'],
            'Passport_Front_Image' => ['nullable', 'image', 'mimes:png,jpg'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'The profile image must be an image file.',
            'CNIC_Front_Image.image' => 'The CNIC front image must be an image file.',
            'CNIC_Front_Image.mimes' => 'The CNIC front image must be a file of type: png, jpg.',
            'CNIC_Back_Image.image' => 'The CNIC back image must be an image file.',
            'CNIC_Back_Image.mimes' => 'The CNIC back image must be a file of type: png, jpg.',
            'Passport_Front_Image.image' => 'The Passport front image must be an image file.',
            'Passport_Front_Image.mimes' => 'The Passport front image must be a file of type: png, jpg.',
        ];
    }
}
