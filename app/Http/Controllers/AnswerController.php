<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Http\Requests\StoreAnswerRequest;
use App\Notifications\NewAnswerNotification;
use App\Notifications\BestAnswerNotification;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(StoreAnswerRequest $request, Question $question)
    {
        $answer = Answer::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'content' => $request->input('content'),
        ]);

        $answerReward = config('reputation.rewards.post_answer', 10);
        
        auth()->user()->increment('reputation', $answerReward);

        if ($question->user_id !== auth()->id()) {
            $question->user->notify(new NewAnswerNotification($answer, $question));
        }

        return redirect()->route('questions.show', $question)
            ->with('success', 'Câu trả lời đã được đăng! Bạn nhận được +' . $answerReward . ' điểm danh vọng.');
    }

    public function markAsBest(Question $question, Answer $answer)
    {
        if ($question->user_id !== auth()->id()) {
            abort(403, 'Chỉ người đăng câu hỏi mới có thể chọn best answer.');
        }

        if ($answer->question_id !== $question->id) {
            abort(404);
        }

        $bestAnswerReward = config('reputation.rewards.best_answer', 25);

        $answer->markAsBest();
        
        $answer->user->increment('reputation', $bestAnswerReward);

        if ($answer->user_id !== auth()->id()) {
            $answer->user->notify(new BestAnswerNotification($answer));
        }

        return redirect()->route('questions.show', $question)
            ->with('success', 'Đã chọn câu trả lời hay nhất! Người trả lời nhận được +' . $bestAnswerReward . ' điểm.');
    }

    public function update(Request $request, Answer $answer)
    {
        $this->authorize('update', $answer);

        $request->validate([
            'content' => 'required|string|min:10',
        ]);

        $answer->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('questions.show', $answer->question)
            ->with('success', 'Câu trả lời đã được cập nhật.');
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);
        $question = $answer->question;
        $answer->delete();

        return redirect()->route('questions.show', $question)
            ->with('success', 'Câu trả lời đã được xóa.');
    }
}