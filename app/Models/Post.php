<?php

namespace App\Models;


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
        'published_at'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
