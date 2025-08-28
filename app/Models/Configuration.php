<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_new_order_email',
        'admin_new_order_email_enabled',
        'wholesale_new_customer_email',
        'wholesale_new_customer_email_enabled',
        'meta',
    ];

    protected $casts = [
        'admin_new_order_email_enabled' => 'boolean',
        'wholesale_new_customer_email_enabled' => 'boolean',
        'meta' => 'array',
    ];

    // Singleton pattern to get the configuration
    public static function getConfiguration()
    {
        return static::firstOrCreate([]);
    }
}
