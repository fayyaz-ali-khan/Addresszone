<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'logo',
        'favicon',
        'site_name',
        'company_name',
        'address',
        'phone',
        'alternate_phone',
        'email',
        'about',
        'terms',
        'privacy',
        'copyright',
        'bank_details',
        'social_links'
    ];
    
    protected $attributes = [
        'bank_details' => '{"account_title" :"", "account_number" : "", "bank_name" :"", "bank_code" : ""}',
        'social_links' => '{"facebook" : "", "twitter" : "", "instagram":"", "youtube" : "", "tiktok" : "", "pinterest" : ""}',
    ];
    
    protected $casts = [
        'bank_details' => 'array',
        'social_links' => 'array',
    ];
}
