<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'reputation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'reputation' => 'integer',
        ];
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function addReputation(int $points): void
    {
        $this->increment('reputation', $points);
    }

    public function canCreateTag(): bool
    {
        $requiredReputation = config('reputation.requirements.create_tag', 50);
        return $this->reputation >= $requiredReputation;
    }

    public function canEditOthersQuestions(): bool
    {
        $requiredReputation = config('reputation.requirements.edit_others_post', 100);
        return $this->reputation >= $requiredReputation;
    }

    public function hasVoted($votable): bool
    {
        return $this->votes()
            ->where('votable_type', get_class($votable))
            ->where('votable_id', $votable->id)
            ->exists();
    }

    public function getVoteType($votable): ?string
    {
        $vote = $this->votes()
            ->where('votable_type', get_class($votable))
            ->where('votable_id', $votable->id)
            ->first();
        
        return $vote ? $vote->vote_type : null;
    }
}