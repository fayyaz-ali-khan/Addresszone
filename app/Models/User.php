<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'password',
        'email_verified_at',
        'address',
        'document_delivery_address',
        'company_name',
        'country',
        'image',
        'CNIC_Front_Image',
        'CNIC_Back_Image',
        'Passport_Front_Image',
        'verification_status',
        'verification_msg',
        'stripe_customer_id',
        'stripe_subscription_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token): void
    {
        // Send only for API users (using sanctum or api guard)
        if (request()->is('api/*')) {
            $this->notify(new CustomResetPasswordNotification($token));
        } else {
            // Fallback to default if needed
            parent::sendPasswordResetNotification($token);
        }
    }
}
