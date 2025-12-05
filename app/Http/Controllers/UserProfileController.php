<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load(['questions', 'answers']);
        
        $questions = $user->questions()
            ->with('tags')
            ->withCount('answers')
            ->latest()
            ->get();
            
        $answers = $user->answers()
            ->with('question')
            ->latest()
            ->get();

        return view('users.profile', compact('user', 'questions', 'answers'));
    }
}