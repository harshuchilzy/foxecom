<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'customer_id',
        'content',
        'rating',
        'approved',
    ];

    public function product()
    {
        return $this->belongsTo(\Lunar\Models\Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(\Lunar\Models\Customer::class);
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class);
    }
}
