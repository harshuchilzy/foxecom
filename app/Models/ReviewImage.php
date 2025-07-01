<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    protected $fillable = ['product_review_id', 'path'];

    public function review()
    {
        return $this->belongsTo(ProductReview::class, 'product_review_id');
    }
}
