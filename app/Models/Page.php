<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'status',
    ];

     protected $casts = [
        'published_at' => 'datetime',
    ];

    public function meta(): HasMany
    {
        return $this->hasMany(PageMeta::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(PageMediaCollection::class);
    }

    public function getMetaKeyValueArray(): array
    {
        return $this->meta->pluck('value', 'key')->toArray();
    }

    public function getMediaCollectionArray(): array
    {
        return $this->gallery->pluck('value', 'key')->toArray();
    }
}
