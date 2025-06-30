<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Redemption extends Model
{
    protected $fillable = ['title', 'content', 'offer_image', 'product_image', 'discount', 'slug'];

    protected static function booted()
    {
        static::creating(function ($redemption) {
            if (empty($redemption->slug)) {
                $redemption->slug = Str::slug($redemption->title);
            }
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(\Lunar\Models\Product::class, 'product_redemption');
    }

}
