<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Nội dung câu trả lời là bắt buộc.',
            'content.min' => 'Câu trả lời phải có ít nhất 10 ký tự.',
        ];
    }
}
