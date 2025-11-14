@extends('layouts.app')

@section('title', 'Tạo bài viết mới')

@section('content')
    <h1 class="text-2xl text-center font-semibold mb-6">Tạo bài viết mới</h1>

    <form method="POST" action="{{ route('admin.posts.store') }}"
        class="max-w-xl mx-auto bg-white shadow rounded p-6 space-y-5">
        @csrf

        <div>
            <label class="block font-medium mb-1 autofocus" for="title">Tiêu đề</label>
            <input type="text" name="title" id="title"
                class="block w-full rounded border border-yellow-500 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 transition"
                value="{{ old('title') }}" autofocus required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block font-medium mb-1">Nội dung</label>
            <textarea name="content" id="content" rows="8"
                class="block w-full rounded border border-yellow-500 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 transition"
                required>{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Trạng thái</label>
            <select name="status"
                class="block w-full rounded border border-yellow-500  focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 transition"
                required>
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Nháp</option>
                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Xuất bản</option>
            </select>
        </div>
        <div>
            <label class="block font-medium mb-1">Kho</label>
            <select name="category"
                class="block w-full rounded border border-yellow-500  focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 transition"
                required>
                <option value="thoi_trang_nam" {{ old('category') === 'Thời trang nam' ? 'selected' : '' }}> Thời trang nam
                </option>
                <option value="dien_thoai_va_phu_kien" {{ old('category') === 'Điện thoại và phụ kiện' ? 'selected' : '' }}>
                    Điện thoại và phụ kiện
                </option>
                <option value="thiet_bi_va_dien_tu" {{ old('category') === 'Thiết bị và điện tử' ? 'selected' : '' }}>Thiết
                    bị và điện tử</option>
                <option value="may_tinh_va_laptop" {{ old('category') === 'Máy tính và laptop' ? 'selected' : '' }}>Máy
                    tính và laptop</option>
            </select>
        </div>
        <div>
            <label class="block font-medium mb-1">Ngày xuất bản (tuỳ chọn)</label>
            <input type="datetime-local" name="published_at"
                class="block w-full rounded border border-yellow-500 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 transition"
                value="{{ old('published_at', old('status') === 'published' ? now()->format('Y-m-d\TH:i') : '') }}
                ">
            <small class="text-gray-500 block mt-1">Nếu để trống và chọn "Xuất bản", hệ thống sẽ lấy thời điểm hiện
                tại.</small>
        </div>


        <div class="flex items-center gap-3 mt-6!">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Lưu</button>
            <a href="{{ route('admin.posts.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Huỷ</a>
        </div>
    </form>
@endsection
