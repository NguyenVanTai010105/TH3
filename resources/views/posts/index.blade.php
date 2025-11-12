@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Danh sách bài viết</h1>
            <div class="grid grid-cols-1 md:grid-cols-1 md:w-full gap-6">
                @foreach ($posts as $post)
                    @if ($post->status === 'published' && $post->published_at->lt(now()))
                        <div class="bg-white rounded shadow p-5 flex flex-col">
                            <div class="flex-1">
                                <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
                                <div class="mb-2">
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700">
                                        {{ $post->status }}
                                    </span>
                                </div>
                                <div class="text-gray-500 text-sm mb-1">Ngày xuất bản:
                                    {{ $post->published_at }}
                                </div>
                                <div class="text-gray-500 text-sm mb-3">Lượt xem: {{ $post->view_count }}</div>
                            </div>
                            <div class="mt-3 flex space-x-2">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">Chi
                                    tiết</a>
                                {{-- <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                    </form> --}}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
