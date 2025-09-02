<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'status' => $this->status,
            'verification_msg' => $this->verification_msg,
            'verification_status' => $this->verification_status,
            'Passport_Front_Image' => $this->Passport_Front_Image,
            'CNIC_Back_Image' => $this->CNIC_Back_Image,
            'CNIC_Front_Image' => $this->CNIC_Front_Image,
            'country' => $this->country,
            'company_name' => $this->company_name,
            'document_delivery_address' => $this->document_delivery_address,
            'address' => $this->address,
            'remember_token' => $this->remember_token,
            'password' => $this->password,
            'email_verified_at' => $this->email_verified_at,
            'image' => $this->image,
            'mobile' => $this->mobile,
            'user_type' => $this->user_type,
            'email' => $this->email,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'name' => $this->name,
            'id' => $this->id,
            'tokens_count' => $this->tokens_count,
            'notifications_count' => $this->notifications_count,
        ];
    }
}
