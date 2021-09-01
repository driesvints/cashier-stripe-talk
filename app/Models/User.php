<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Cashier;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Billable;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected static function booted()
    {
        static::updated(function ($customer) {
            $customer->syncStripeCustomerDetails();
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function hasOrders(): bool
    {
        return $this->orders()->exists();
    }

    public function basicAmount(): string
    {
        return Cashier::formatAmount($this->rawBasicAmount(), 'EUR');
    }

    public function rawBasicAmount(): int
    {
        // if ($this->hasOrders()) {
        //     return 499 + ($this->orders()->count() * 0.25 * 100);
        // }

        return 499;
    }
}
