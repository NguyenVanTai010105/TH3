@extends('layouts.app')

@section('title', 'Đăng câu hỏi mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold">Đăng câu hỏi mới</h1>
            <p class="text-gray-600 mt-2">Nhận +{{ config('reputation.rewards.post_question', 5) }} điểm danh vọng khi đăng câu hỏi</p>
        </div>

        <form action="{{ route('questions.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tiêu đề câu hỏi <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full border rounded-lg p-3 @error('title') border-red-500 @enderror" 
                       placeholder="Ví dụ: Làm thế nào để sử dụng Laravel Gates?"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Tối thiểu 10 ký tự. Hãy đặt câu hỏi rõ ràng và súc tích.</p>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nội dung chi tiết <span class="text-red-500">*</span>
                </label>
                <textarea name="content" 
                          id="content"
                          rows="12" 
                          class="w-full border rounded-lg p-3 font-mono @error('content') border-red-500 @enderror" 
                          placeholder="Mô tả chi tiết vấn đề của bạn... 

Hỗ trợ Markdown:
- **in đậm**
- *in nghiêng*
- `code`
- ```code block```
- [link](url)"
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Tối thiểu 20 ký tự. Hỗ trợ định dạng Markdown.</p>
            </div>

            <!-- Live Preview -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Xem trước
                </label>
                <div id="preview" class="border rounded-lg p-4 bg-gray-50 markdown-content min-h-[100px]">
                    <p class="text-gray-400">Nội dung xem trước sẽ hiển thị ở đây...</p>
                </div>
            </div>

            <!-- Tags -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tags (tùy chọn)
                </label>
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="tags[]" 
                                   value="{{ $tag->id }}"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tags')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm">Chọn tối đa 5 tags. 
                    @if(auth()->user()->canCreateTag())
                        <a href="{{ route('tags.create') }}" class="text-blue-600 hover:underline">Tạo tag mới</a>
                    @else
                        <span class="text-gray-400">(Cần {{ config('reputation.requirements.create_tag', 50) }} điểm để tạo tag mới)</span>
                    @endif
                </p>
            </div>

            <!-- Tips -->
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-semibold text-blue-900 mb-2">💡 Mẹo đặt câu hỏi hay:</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>✓ Tiêu đề ngắn gọn, dễ hiểu</li>
                    <li>✓ Mô tả rõ ràng vấn đề bạn gặp phải</li>
                    <li>✓ Đính kèm code hoặc ví dụ minh họa</li>
                    <li>✓ Cho biết bạn đã thử những gì</li>
                    <li>✓ Chọn tags phù hợp để người khác dễ tìm</li>
                </ul>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between">
                <a href="{{ route('questions.index') }}" class="text-gray-600 hover:text-gray-900">
                    ← Quay lại
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Đăng câu hỏi (+{{ config('reputation.rewards.post_question', 5) }} điểm)
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    const contentTextarea = document.getElementById('content');
    const preview = document.getElementById('preview');
    
    // Update preview when typing
    contentTextarea.addEventListener('input', function() {
        if (this.value.trim() === '') {
            preview.innerHTML = '<p class="text-gray-400">Nội dung xem trước sẽ hiển thị ở đây...</p>';
        } else {
            preview.innerHTML = marked.parse(this.value);
        }
    });

    // Limit tag selection to 5
    const tagCheckboxes = document.querySelectorAll('input[name="tags[]"]');
    tagCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('input[name="tags[]"]:checked').length;
            if (checkedCount > 5) {
                this.checked = false;
                alert('Bạn chỉ có thể chọn tối đa 5 tags!');
            }
        });
    });
</script>
@endsection