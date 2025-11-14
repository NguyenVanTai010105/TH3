@extends('layouts.app')

@if (session('success_create'))
    <script>
        alert("{{ session('success_create') }}");
    </script>
@elseif(session('success_deleted'))
    <script>
        alert("{{ session('success_deleted') }}");
    </script>
@endif


@section('content')
    <form method="POST" action="{{ route('admin.categories.store') }}"
        class="max-w-xl mx-auto bg-white shadow rounded p-6 space-y-5">
        @csrf

        <div>
            <label class="block font-medium mb-1">Tên danh mục</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nhập tên danh mục"
                class="block w-full rounded border border-yellow-500 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2 transition"
                required>

            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
                Tạo danh mục
            </button>
        </div>
    </form>
    <div class="min-h-screen bg-gray-50 p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Danh sách bài viết</h1>

            <div class="grid grid-cols-1 gap-4">
                @foreach ($categories as $category)
                    <div
                        class="p-4 bg-white rounded-xl shadow-sm border flex justify-between items-center hover:shadow-md transition">
                        <h2 class="text-lg font-semibold text-gray-700">
                            {{ $category->name }}
                        </h2>

                        <!-- Nút Xóa -->
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này không?');">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-3 py-1.5 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition">
                                Xóa
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
