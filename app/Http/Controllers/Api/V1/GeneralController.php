<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\GeneralSetting;
use App\Http\Resources\GeneralFrotentedResource;

class GeneralController
{


    public function generalAppData()
    {


        $data = GeneralSetting::select(
            'logo',
            'favicon',
            'site_name',
            'company_name',
            'address',
            'phone',
            'alternate_phone',
            'email',
            'copyright',
            'bank_details',
            'social_links',
        )->first();

        return response()->json(['data' => new GeneralFrotentedResource($data)]);
    }
}
