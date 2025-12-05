<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    public function update(User $user, Question $question): bool
    {
        // Owner can always edit
        if ($question->user_id === $user->id) {
            return true;
        }
        
        // Users with 100+ reputation can edit others' questions
        return $user->reputation >= 100;
    }

    public function delete(User $user, Question $question): bool
    {
        return $question->user_id === $user->id;
    }

    public function markBestAnswer(User $user, Question $question): bool
    {
        return $question->user_id === $user->id;
    }
}