<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'check_out_no',
        'agent_id',
        'user_id',
        'payment_method',
        'payment_details',
        'PayerID',
        'coupon_code',
        'coupon_price',
        'coupon_type',
        'coupon_criteria',
        'discounted_price',
        'discount',
        'grand_total',
        'pak_price',
        'email',
        'mobile',
        'name',
        'country',
        'company_name',
        'address',
        'paid',
        'expired_status',
        'status',
        'created_by',
        'packageType',
        'service_name',
        'stripe_customer_id',
        'stripe_subsription_id',
    ];

}
