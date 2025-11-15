@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-center">Danh sách bài viết</h1>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                @forelse ($posts as $post)
                    @if ($post->status === 'published' && $post->published_at && $post->published_at->lt(now()))
                        <div class="bg-white rounded-xl shadow p-5 flex flex-col hover:shadow-lg transition">
                            <div class="flex-1">
                                <h2 class="text-2xl font-semibold mb-2">{{ $post->title }}</h2>

                                {{-- Category --}}
                                @if ($post->category)
                                    <a href="{{ route('posts.byCategory', $post->category->id) }}"
                                        class="px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition">
                                        {{ $post->category->name }}
                                    </a>
                                @endif

                                {{-- Tags --}}
                                @if ($post->tags && $post->tags->isNotEmpty())
                                    <div class="mb-2 flex flex-wrap gap-2 mt-2">
                                        @foreach ($post->tags as $tag)
                                            <a href="{{ route('posts.byTag', $tag->id) }}"
                                                class="px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                                                {{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Status, Published date, Views --}}
                                <div class="flex items-center space-x-4 text-gray-500 text-sm mb-2 mt-2">
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-700">{{ $post->status }}</span>
                                    <span>Ngày xuất bản: {{ $post->published_at->format('d-m-Y H:i') }}</span>
                                    <span>Lượt xem: {{ $post->view_count }}</span>
                                </div>

                                <p class="text-gray-700 mt-2 line-clamp-3">{{ $post->content }}</p>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-gray-500 text-center">Hiện chưa có bài viết nào.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
