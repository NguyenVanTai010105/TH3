@extends('layouts.app')

@section('title', 'Hồ sơ - ' . $user->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- User Header -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-8">
            <div class="flex items-start space-x-6">
                <!-- Avatar -->
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                    {{ substr($user->name, 0, 1) }}
                </div>

                <!-- User Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ $user->name }}</h1>
                    
                    <div class="flex items-center space-x-6 text-gray-600 mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="font-bold text-lg">{{ $user->reputation }} điểm danh vọng</span>
                        </div>
                        <div>
                            Tham gia {{ $user->created_at->format('d/m/Y') }}
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mt-6">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $questions->count() }}</div>
                            <div class="text-sm text-gray-600">Câu hỏi</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $answers->count() }}</div>
                            <div class="text-sm text-gray-600">Câu trả lời</div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $answers->where('is_best', true)->count() }}</div>
                            <div class="text-sm text-gray-600">Câu trả lời hay nhất</div>
                        </div>
                    </div>

                    <!-- Badges -->
                    <div class="mt-6">
                        <h3 class="font-semibold mb-2">Huy hiệu</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($user->reputation >= config('reputation.requirements.edit_others_post', 100))
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    🏆 Biên tập viên ({{ config('reputation.requirements.edit_others_post', 100) }}+ điểm)
                                </span>
                            @endif
                            
                            @if($user->reputation >= config('reputation.requirements.create_tag', 50))
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    🏷️ Người tạo Tag ({{ config('reputation.requirements.create_tag', 50) }}+ điểm)
                                </span>
                            @endif
                            
                            @if($questions->count() >= 10)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    ❓ Người đặt câu hỏi (10+ câu hỏi)
                                </span>
                            @endif
                            
                            @if($answers->count() >= 20)
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                    💬 Người trả lời tích cực (20+ câu trả lời)
                                </span>
                            @endif
                            
                            @if($answers->where('is_best', true)->count() >= 5)
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                    ⭐ Chuyên gia (5+ câu trả lời hay nhất)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow" x-data="{ tab: 'questions' }">
        <div class="border-b">
            <div class="flex space-x-1 p-4">
                <button @click="tab = 'questions'" 
                        :class="tab === 'questions' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100'"
                        class="px-4 py-2 rounded-lg font-medium transition">
                    Câu hỏi ({{ $questions->count() }})
                </button>
                <button @click="tab = 'answers'" 
                        :class="tab === 'answers' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100'"
                        class="px-4 py-2 rounded-lg font-medium transition">
                    Câu trả lời ({{ $answers->count() }})
                </button>
            </div>
        </div>

        <!-- Questions Tab -->
        <div x-show="tab === 'questions'" class="divide-y">
            @forelse($questions as $question)
                <div class="p-6 hover:bg-gray-50">
                    <h3 class="text-lg font-semibold mb-2">
                        <a href="{{ route('questions.show', $question) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $question->title }}
                        </a>
                    </h3>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span>{{ $question->getVoteScore() }} votes</span>
                        <span>{{ $question->answers_count }} câu trả lời</span>
                        <span>{{ $question->views }} lượt xem</span>
                        <span>{{ $question->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($question->tags as $tag)
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    Chưa có câu hỏi nào
                </div>
            @endforelse
        </div>

        <!-- Answers Tab -->
        <div x-show="tab === 'answers'" class="divide-y">
            @forelse($answers as $answer)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start space-x-3">
                        @if($answer->is_best)
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="text-gray-700 mb-2">
                                Trả lời cho: 
                                <a href="{{ route('questions.show', $answer->question) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $answer->question->title }}
                                </a>
                            </div>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ Str::limit(strip_tags($answer->content), 200) }}
                            </p>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>{{ $answer->getVoteScore() }} votes</span>
                                @if($answer->is_best)
                                    <span class="text-green-600 font-medium">✓ Câu trả lời hay nhất</span>
                                @endif
                                <span>{{ $answer->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    Chưa có câu trả lời nào
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection