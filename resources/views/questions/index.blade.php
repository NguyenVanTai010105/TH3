@extends('layouts.app')

@section('title', 'Câu hỏi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Tất cả câu hỏi</h1>
                    @auth
                        <a href="{{ route('questions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Đặt câu hỏi mới
                        </a>
                    @endauth
                </div>
            </div>

            <div class="divide-y">
                @forelse($questions as $question)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex space-x-4">
                            <!-- Stats -->
                            <div class="flex flex-col items-center space-y-2 text-sm text-gray-600">
                                <div class="text-center">
                                    <div class="font-semibold text-lg">{{ $question->getVoteScore() }}</div>
                                    <div>votes</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold text-lg {{ $question->answers_count > 0 ? 'text-green-600' : '' }}">
                                        {{ $question->answers_count }}
                                    </div>
                                    <div>answers</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold text-lg">{{ $question->views }}</div>
                                    <div>views</div>
                                </div>
                            </div>

                            <!-- Question Content -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2">
                                    <a href="{{ route('questions.show', $question) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $question->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-3">
                                    {{ Str::limit(strip_tags($question->content), 200) }}
                                </p>

                                <!-- Tags -->
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach($question->tags as $tag)
                                        <a href="{{ route('tags.show', $tag) }}" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm hover:bg-blue-200">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>

                                <!-- Meta Info -->
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('users.profile', $question->user) }}" class="flex items-center space-x-1 hover:text-blue-600">
                                            <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs">
                                                {{ substr($question->user->name, 0, 1) }}
                                            </div>
                                            <span>{{ $question->user->name }}</span>
                                        </a>
                                        <span>⭐ {{ $question->user->reputation }}</span>
                                    </div>
                                    <span>{{ $question->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        Chưa có câu hỏi nào. Hãy là người đầu tiên đặt câu hỏi!
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="p-6">
                {{ $questions->links() }}
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold mb-4">📊 Thống kê</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Tổng câu hỏi:</span>
                    <span class="font-semibold">{{ \App\Models\Question::count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tổng câu trả lời:</span>
                    <span class="font-semibold">{{ \App\Models\Answer::count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Người dùng:</span>
                    <span class="font-semibold">{{ \App\Models\User::count() }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4">🏷️ Tags phổ biến</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(\App\Models\Tag::withCount('questions')->orderBy('questions_count', 'desc')->limit(10)->get() as $tag)
                    <a href="{{ route('tags.show', $tag) }}" class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm hover:bg-gray-200">
                        {{ $tag->name }} ({{ $tag->questions_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection