<?php

namespace App\Models;

use Carbon\Factory;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected static function newFactory()
    {
        return PostFactory::new();
    }
    protected $casts = [
        'published_at' => 'datetime'
    ];
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'published_at',

    ];
}
