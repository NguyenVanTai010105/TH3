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
        'published_at',
        'category_id'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
