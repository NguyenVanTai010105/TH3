<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\BestAnswerNotification;
use Illuminate\Support\Facades\DB;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'content',
        'is_best',
    ];

    protected $casts = [
        'is_best' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // Helper methods
    public function markAsBest(): void
    {
        // Start transaction
        DB::transaction(function () {
            // Remove best status from all other answers for this question
            Answer::where('question_id', $this->question_id)
                ->where('id', '!=', $this->id)
                ->update(['is_best' => false]);

            // Mark this answer as best
            $this->update(['is_best' => true]);

            // Award reputation to answer author
            $this->user->addReputation(20);

            // Send notification to answer author (if not self)
            if ($this->user_id !== $this->question->user_id) {
                $this->user->notify(new BestAnswerNotification($this));
            }
        });
    }

    public function unmarkAsBest(): void
    {
        $this->update(['is_best' => false]);
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

    // Scopes
    public function scopeBest($query)
    {
        return $query->where('is_best', true);
    }

    public function scopeWithVoteScore($query)
    {
        return $query->withCount([
            'votes as upvotes' => function ($query) {
                $query->where('vote_type', 'up');
            },
            'votes as downvotes' => function ($query) {
                $query->where('vote_type', 'down');
            }
        ]);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('is_best', 'desc')->latest();
    }
}