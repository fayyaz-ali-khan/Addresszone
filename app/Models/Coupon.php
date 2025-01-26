<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'type',
        'amount',
        'status',
        'admin_id',
        'user_id',
    ];

    function usedBy(){
        return $this->belongsTo(User::class,'user_id');
    }

    function createdBy(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
