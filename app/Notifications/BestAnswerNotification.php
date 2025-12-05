<?php

namespace App\Notifications;

use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BestAnswerNotification extends Notification
{
    use Queueable;

    protected $answer;

    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'Câu trả lời của bạn đã được chọn là câu trả lời hay nhất!',
            'question_id' => $this->answer->question_id,
            'question_title' => $this->answer->question->title,
            'answer_id' => $this->answer->id,
            'reputation_earned' => 20,
        ];
    }
}