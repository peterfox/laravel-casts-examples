<?php

namespace App\Models;

use App\Casts\Address;
use App\Casts\DateInterval;
use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => Money::class,
        'address' => Address::class,
        'days' => DateInterval::class . ':days',
    ];
}
