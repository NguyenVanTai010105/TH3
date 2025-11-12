@extends('layouts.app')

@section('title', 'Chi tiết bài viết')

@section('content')
    <h1>{{ $post->title }}</h1>
    <div class="text-muted mb-2">
        Trạng thái: {{ $post->status }} — Published at: {{ $post->published_at?->format('d/m/Y H:i') ?: '-' }}
    </div>
    <div>{!! nl2br(e($post->content)) !!}</div>

    <div class="mt-3">
        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary">Sửa</a>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
@endsection
