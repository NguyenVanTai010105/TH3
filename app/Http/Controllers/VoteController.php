<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Request $request)
    {
        $request->validate([
            'votable_type' => 'required|in:question,answer',
            'votable_id' => 'required|integer',
            'vote_type' => 'required|in:up,down',
        ]);

        $votableClass = $request->votable_type === 'question' 
            ? Question::class 
            : Answer::class;

        $votable = $votableClass::findOrFail($request->votable_id);
        
        $upvoteReward = config('reputation.rewards.receive_upvote', 10);

        $existingVote = Vote::where('user_id', auth()->id())
            ->where('votable_type', $votableClass)
            ->where('votable_id', $votable->id)
            ->first();

        if ($existingVote) {
            if ($existingVote->vote_type === $request->vote_type) {
                if ($existingVote->vote_type === 'up') {
                    $votable->user->decrement('reputation', $upvoteReward);
                }
                
                $existingVote->delete();
            } else {
                if ($request->vote_type === 'up') {
                    $votable->user->increment('reputation', $upvoteReward);
                } else {
                    $votable->user->decrement('reputation', $upvoteReward);
                }
                
                $existingVote->update(['vote_type' => $request->vote_type]);
            }
        } else {
            Vote::create([
                'user_id' => auth()->id(),
                'votable_type' => $votableClass,
                'votable_id' => $votable->id,
                'vote_type' => $request->vote_type,
            ]);
            
            if ($request->vote_type === 'up') {
                $votable->user->increment('reputation', $upvoteReward);
            }
        }

        $upvotes = $votable->votes()->where('vote_type', 'up')->count();
        $downvotes = $votable->votes()->where('vote_type', 'down')->count();
        $score = $upvotes - $downvotes;

        return response()->json([
            'success' => true,
            'score' => $score,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'user_vote' => auth()->user()->getVoteType($votable),
        ]);
    }
}