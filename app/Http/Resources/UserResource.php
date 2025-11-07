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
            'id' => $this->id,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'verification_msg' => $this->verification_msg,
            'verification_status' => $this->verification_status,
            'country' => $this->country,
            'company_name' => $this->company_name,
            'document_delivery_address' => $this->document_delivery_address,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'name' => $this->name,

            'image' => $this->image ? asset('storage/' . $this->image) : asset('admin/images/avatar.png'),
            'Passport_Front_Image' => $this->Passport_Front_Image ? asset('storage/' . $this->Passport_Front_Image) : null,
            'CNIC_Back_Image' => $this->CNIC_Back_Image ? asset('storage/' . $this->CNIC_Back_Image) : null,
            'CNIC_Front_Image' => $this->CNIC_Front_Image ? asset('storage/' . $this->CNIC_Front_Image) : null,

            'documents' => DocumentResource::collection($this->whenLoaded('documents'))
        ];
    }
}
