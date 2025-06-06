<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'is_sticky',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_sticky' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
