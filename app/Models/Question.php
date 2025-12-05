<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'slug',
        'views',
    ];

    protected $casts = [
        'views' => 'integer',
    ];

    // Auto-generate slug
    protected static function boot()
    {
    parent::boot();
    
    // Tự động tạo slug khi tạo câu hỏi mới
    static::creating(function ($question) {
        if (empty($question->slug)) {
            $question->slug = Str::slug($question->title);
        }
    });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // Helper methods
    public function bestAnswer()
    {
        return $this->hasOne(Answer::class)->where('is_best', true);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getVoteScore(): int
    {
        $upvotes = $this->votes()->where('vote_type', 'up')->count();
        $downvotes = $this->votes()->where('vote_type', 'down')->count();
        return $upvotes - $downvotes;
    }

    public function getUpvotesCount(): int
    {
        return $this->votes()->where('vote_type', 'up')->count();
    }

    public function getDownvotesCount(): int
    {
        return $this->votes()->where('vote_type', 'down')->count();
    }

    public function hasBestAnswer(): bool
    {
        return $this->answers()->where('is_best', true)->exists();
    }

    // Route model binding by slug
    public function getRouteKeyName()
    {
        return 'id';
    }

    
}