<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Redemption extends Model
{
    protected $fillable = ['title', 'content', 'offer_image', 'product_image', 'discount'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(\Lunar\Models\Product::class, 'product_redemption');
    }

}
