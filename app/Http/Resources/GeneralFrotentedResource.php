<?php

namespace App\Http\Resources;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class GeneralFrotentedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'logo' => asset('storage/' . $this->logo),
            'favicon' => asset('storage/' . $this->favicon),
            'site_name' => $this->site_name,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'alternate_phone' => $this->alternate_phone,
            'email' => $this->email,
            'copyright' => $this->copyright,
            'bank_details' => $this->bank_details,
            'social_links' => $this->social_links,

        ];
    }
}
