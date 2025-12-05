<?php

namespace App\Providers;

use App\Models\Question;
use App\Models\Answer;
use App\Policies\QuestionPolicy;
use App\Policies\AnswerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate for creating tags (50+ reputation required)
        Gate::define('create-tag', function ($user) {
            return $user->reputation >= 50;
        });

        // Gate for editing others' questions (100+ reputation required)
        Gate::define('edit-question', function ($user, $question) {
            if ($question->user_id === $user->id) {
                return true;
            }
            return $user->reputation >= 100;
        });

        // Gate for marking best answer (only question owner)
        Gate::define('mark-best-answer', function ($user, $question) {
            return $question->user_id === $user->id;
        });
    }
}