<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'short_description',
        'description',
        'images',
        'weight',
        'length',
        'width',
        'height',
        'virtual',
        'downloadable',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'virtual' => 'boolean',
        'downloadable' => 'boolean',
        'price' => 'float',
        'sale_price' => 'float',
    ];
}
