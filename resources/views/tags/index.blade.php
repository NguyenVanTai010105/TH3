@extends('layouts.app')
@section('title', 'Tags')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tất cả Tags</h1>
        @auth
            @can('create-tag')
                <a href="{{ route('tags.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tạo Tag mới</a>
            @endcan
        @endauth
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($tags as $tag)
            <a href="{{ route('tags.show', $tag) }}" class="p-4 border rounded hover:bg-gray-50">
                <div class="font-semibold">{{ $tag->name }}</div>
                <div class="text-sm text-gray-600">{{ $tag->questions_count }} câu hỏi</div>
            </a>
        @endforeach
    </div>
</div>
@endsection