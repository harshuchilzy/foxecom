<?php

namespace App\Models;

use Lunar\Models\Order;

class ExtendLunarOrder extends Order
{
    protected $fillable = [
        'transaction_reference',
        'worldpay_meta'
    ];

    protected $casts = [
        'worldpay_meta' => 'array',
    ];
}
