<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'amount',
        'description',
        'free_shipping',
        'expiry_date',
        'minimum_amount',
        'maximum_amount',
        'usage_limit',
        'usage_count',
        'individual_use',
        'exclude_sale_items',
    ];

    protected $casts = [
        'free_shipping' => 'boolean',
        'individual_use' => 'boolean',
        'exclude_sale_items' => 'boolean',
        'expiry_date' => 'date',
    ];
}
