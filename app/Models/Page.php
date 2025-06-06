<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'author_id', 'content', 'template', 'status',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
