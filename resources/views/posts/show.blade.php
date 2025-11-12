@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-emerald-100 flex items-center justify-center py-8">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl w-full">
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
            <div class="flex items-center mb-4">
                <span class="px-3 py-1 rounded text-xs font-medium bg-green-100 text-green-700
               ">
                    {{ $post->status }}
                </span>
                <span class="ml-4 text-gray-500 text-sm">
                    Ngày xuất bản:
                    {{ $post->published_at ? $post->published_at->format('d-m-Y') : '-' }}
                </span>
                <span class="ml-4 text-gray-500 text-sm">Lượt xem: {{ $post->view_count }}</span>
            </div>
            <hr class="my-4">
            <div class="prose mb-4">
                {!! $post->content !!}
            </div>
            <div class="flex space-x-2 mt-4">
                <a href="{{ route('posts.index') }}"
                    class="px-4 py-2 bg-emerald-400 text-white rounded hover:bg-emerald-600">Quay lại</a>
            </div>
        </div>
    </div>
@endsection
