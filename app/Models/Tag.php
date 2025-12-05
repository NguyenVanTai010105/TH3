<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $baseSlug = Str::slug($tag->name);
                $slug = $baseSlug;
                $count = 1;
                
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }
                
                $tag->slug = $slug;
            }
        });
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_tag');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}