<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageMediaCollection extends Model
{
    protected $fillable = [
        'page_id',
        'key',
        'value',
    ];
    
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
