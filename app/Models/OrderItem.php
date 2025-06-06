<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'product_name', 'price', 'quantity'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($item) {
            if (!$item->product_name && $item->product_id) {
                $item->product_name = optional($item->product)->name;
            }

            if (!$item->price && $item->product_id) {
                $item->price = optional($item->product)->price;
            }
        });
    }
}
