<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Cashier;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function total(): string
    {
        return Cashier::formatAmount($this->total, 'EUR');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
