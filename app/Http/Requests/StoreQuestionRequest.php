<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:255',
            'content' => 'required|string|min:20',
            'tags' => 'nullable|array|max:5',
            'tags.*' => 'exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề câu hỏi là bắt buộc.',
            'title.min' => 'Tiêu đề phải có ít nhất 10 ký tự.',
            'content.required' => 'Nội dung câu hỏi là bắt buộc.',
            'content.min' => 'Nội dung phải có ít nhất 20 ký tự.',
            'tags.max' => 'Bạn chỉ có thể chọn tối đa 5 tags.',
        ];
    }
}
