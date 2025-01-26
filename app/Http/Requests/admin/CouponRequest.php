<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    
    protected $route='admin.coupons.store';
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

  
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:24', 
            Rule::unique('coupons')->ignore($this->coupon?->id) // Ignore current coupon
        ],
            'type' => 'required|in:fixed,percentage',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ];
    }
}
