<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageMeta extends Model
{
    protected $fillable = [
        'page_id',
        'key',
        'value',
        'type'
    ];
    
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
