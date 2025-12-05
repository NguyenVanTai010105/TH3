@extends('layouts.app')
@section('title', 'Tag: ' . $tag->name)
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tag: {{ $tag->name }}</h1>
    <div class="divide-y">
        @foreach($questions as $question)
            <div class="py-4">
                <h3 class="text-lg font-semibold mb-2">
                    <a href="{{ route('questions.show', $question) }}" class="text-blue-600 hover:underline">
                        {{ $question->title }}
                    </a>
                </h3>
                <div class="text-sm text-gray-600">
                    {{ $question->answers_count }} câu trả lời • {{ $question->created_at->diffForHumans() }}
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $questions->links() }}</div>
</div>
@endsection