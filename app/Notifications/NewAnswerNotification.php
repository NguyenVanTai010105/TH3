<?php

namespace App\Notifications;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewAnswerNotification extends Notification
{
    use Queueable;

    protected $answer;
    protected $question;

    public function __construct(Answer $answer, Question $question)
    {
        $this->answer = $answer;
        $this->question = $question;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->answer->user->name . ' đã trả lời câu hỏi của bạn',
            'question_id' => $this->question->id,
            'question_title' => $this->question->title,
            'answer_id' => $this->answer->id,
            'answerer_name' => $this->answer->user->name,
        ];
    }
}