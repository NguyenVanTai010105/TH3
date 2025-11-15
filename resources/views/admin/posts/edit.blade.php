@extends('layouts.app')

@section('title', 'Sửa bài viết')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Sửa bài viết</h1>

        <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" class="space-y-6">
            @csrf
            @method('PUT')


            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề</label>
                <input type="text" name="title"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    value="{{ old('title', $post->title) }}" required>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nội dung</label>
                <textarea name="content" rows="8"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"
                    required>{{ old('content', $post->content) }}</textarea>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái</label>
                <select name="status"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Xuất bản
                    </option>
                </select>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ngày xuất bản (tuỳ chọn)</label>
                <input type="datetime-local" name="published_at"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                <p class="text-xs text-gray-500 mt-1">Nếu để trống và chọn "Xuất bản", hệ thống sẽ lấy thời điểm hiện tại.
                </p>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Danh mục</label>
                <select name="category_id"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tags (phân tách bằng dấu ,)</label>
                <input type="text" name="tags"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}">
                <p class="text-xs text-gray-500 mt-1">Nhập nhiều tag cách nhau bằng dấu phẩy. Ví dụ: Laravel, PHP, Database.
                </p>
            </div>

            {{-- Nút hành động --}}
            <div class="flex items-center justify-between pt-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-xl hover:bg-blue-700 transition duration-200">
                    💾 Cập nhật
                </button>

                <a href="{{ route('admin.posts.index') }}"
                    class="text-gray-600 hover:text-gray-800 px-4 py-2 border border-gray-300 rounded-xl transition duration-200">
                    ❌ Huỷ
                </a>
            </div>
        </form>
    </div>
@endsection
