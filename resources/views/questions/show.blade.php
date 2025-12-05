@extends('layouts.app')

@section('title', $question->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <!-- Question Card -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <div class="flex space-x-4">
                    <!-- Vote Section -->
                    <div class="flex flex-col items-center space-y-2" 
                         x-data="voteComponent('question', {{ $question->id }}, {{ $question->getVoteScore() }}, '{{ auth()->check() ? auth()->user()->getVoteType($question) : '' }}')">
                        <button @click="vote('up')" 
                                :class="userVote === 'up' ? 'text-blue-600' : 'text-gray-400'"
                                class="hover:text-blue-600 transition"
                                @auth @else onclick="alert('Vui lòng đăng nhập để vote'); return false;" @endauth>
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3.5l3.5 7h-7l3.5-7z"/>
                            </svg>
                        </button>
                        <div class="text-2xl font-bold" x-text="score"></div>
                        <button @click="vote('down')" 
                                :class="userVote === 'down' ? 'text-red-600' : 'text-gray-400'"
                                class="hover:text-red-600 transition"
                                @auth @else onclick="alert('Vui lòng đăng nhập để vote'); return false;" @endauth>
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 16.5l-3.5-7h7l-3.5 7z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Question Content -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold mb-4">{{ $question->title }}</h1>

                        <div class="markdown-content prose max-w-none mb-6">
                            {!! \Illuminate\Support\Str::markdown($question->content) !!}
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($question->tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm hover:bg-blue-200">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Author Info -->
                        <div class="flex items-center justify-between border-t pt-4">
                            <div class="flex space-x-2">
                                @can('update', $question)
                                    <a href="{{ route('questions.edit', $question) }}" class="text-sm text-blue-600 hover:underline">
                                        Chỉnh sửa
                                    </a>
                                @endcan
                                @can('delete', $question)
                                    <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-600 hover:underline">Xóa</button>
                                    </form>
                                @endcan
                            </div>

                            <div class="bg-blue-50 p-4 rounded">
                                <div class="text-xs text-gray-600 mb-2">Đăng bởi</div>
                                <a href="{{ route('users.profile', $question->user) }}" class="flex items-center space-x-2 hover:text-blue-600">
                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($question->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $question->user->name }}</div>
                                        <div class="text-sm text-gray-600">⭐ {{ $question->user->reputation }} điểm</div>
                                    </div>
                                </a>
                                <div class="text-xs text-gray-500 mt-2">{{ $question->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Answers Section -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold">{{ $question->answers->count() }} Câu trả lời</h2>
            </div>

            <div class="divide-y">
                @foreach($question->answers as $answer)
                    <div class="p-6 {{ $answer->is_best ? 'best-answer' : '' }}">
                        <div class="flex space-x-4">
                            <!-- Vote Section -->
                            <div class="flex flex-col items-center space-y-2"
                                 x-data="voteComponent('answer', {{ $answer->id }}, {{ $answer->getVoteScore() }}, '{{ auth()->check() ? auth()->user()->getVoteType($answer) : '' }}')">
                                <button @click="vote('up')" 
                                        :class="userVote === 'up' ? 'text-blue-600' : 'text-gray-400'"
                                        class="hover:text-blue-600 transition"
                                        @auth @else onclick="alert('Vui lòng đăng nhập'); return false;" @endauth>
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3.5l3.5 7h-7l3.5-7z"/>
                                    </svg>
                                </button>
                                <div class="text-xl font-bold" x-text="score"></div>
                                <button @click="vote('down')" 
                                        :class="userVote === 'down' ? 'text-red-600' : 'text-gray-400'"
                                        class="hover:text-red-600 transition"
                                        @auth @else onclick="alert('Vui lòng đăng nhập'); return false;" @endauth>
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 16.5l-3.5-7h7l-3.5 7z"/>
                                    </svg>
                                </button>

                                @can('markBestAnswer', $question)
                                    @if(!$answer->is_best)
                                        <form action="{{ route('answers.mark-best', [$question, $answer]) }}" method="POST" class="mt-2">
                                            @csrf
                                            <button class="text-gray-400 hover:text-green-600 transition" title="Chọn là câu trả lời hay nhất">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <div class="mt-2 text-green-600" title="Câu trả lời hay nhất">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </div>
                                    @endif
                                @endcan
                            </div>

                            <!-- Answer Content -->
                            <div class="flex-1">
                                @if($answer->is_best)
                                    <div class="mb-3 inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        ✓ Câu trả lời hay nhất
                                    </div>
                                @endif

                                <div class="markdown-content prose max-w-none mb-4">
                                    {!! \Illuminate\Support\Str::markdown($answer->content) !!}
                                </div>

                                <div class="flex items-center justify-between border-t pt-4">
                                    <div class="flex space-x-2">
                                        @can('update', $answer)
                                            <button onclick="toggleEdit('{{$answer->id}}')" class="text-sm text-blue-600 hover:underline">
                                                Chỉnh sửa
                                            </button>
                                        @endcan
                                        @can('delete', $answer)
                                            <form action="{{ route('answers.destroy', $answer) }}" method="POST" onsubmit="return confirm('Xóa câu trả lời?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-sm text-red-600 hover:underline">Xóa</button>
                                            </form>
                                        @endcan
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded">
                                        <div class="text-xs text-gray-600 mb-2">Trả lời bởi</div>
                                        <a href="{{ route('users.profile', $answer->user) }}" class="flex items-center space-x-2 hover:text-blue-600">
                                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                                {{ substr($answer->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-sm">{{ $answer->user->name }}</div>
                                                <div class="text-xs text-gray-600">⭐ {{ $answer->user->reputation }}</div>
                                            </div>
                                        </a>
                                        <div class="text-xs text-gray-500 mt-2">{{ $answer->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>

                                <!-- Edit Form (hidden by default) -->
                                @can('update', $answer)
                                    <div id="edit-form-{{ $answer->id }}" class="hidden mt-4">
                                        <form action="{{ route('answers.update', $answer) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="content" rows="6" class="w-full border rounded p-3">{{ $answer->content }}</textarea>
                                            <div class="mt-2 flex space-x-2">
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                    Cập nhật
                                                </button>
                                                <button type="button" onclick="toggleEdit('{{$answer->id}}')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                                    Hủy
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <script>
                                        function toggleEdit(answerId) {
                                            var formId = 'edit-form-' + answerId;
                                            var editForm = document.getElementById(formId);

                                            editForm.classList.toggle('hidden');
                                        }
                                    </script>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Answer Form -->
            @auth
                <div class="p-6 bg-gray-50 border-t">
                    <h3 class="font-bold mb-4">Câu trả lời của bạn</h3>
                    <form action="{{ route('answers.store', $question) }}" method="POST">
                        @csrf
                        <textarea name="content" rows="6" 
                                  class="w-full border rounded p-3 @error('content') border-red-500 @enderror" 
                                  placeholder="Nhập câu trả lời của bạn (hỗ trợ Markdown)..." 
                                  required></textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <div class="mt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Đăng câu trả lời (+{{ config('reputation.rewards.post_answer', 10) }} điểm)
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-6 bg-gray-50 border-t text-center">
                    <p class="text-gray-600">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Đăng nhập</a> 
                        để trả lời câu hỏi
                    </p>
                </div>
            @endauth
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4">Thông tin</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Lượt xem:</span>
                    <span class="font-semibold">{{ $question->views }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Câu trả lời:</span>
                    <span class="font-semibold">{{ $question->answers->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Đăng lúc:</span>
                    <span class="font-semibold">{{ $question->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function voteComponent(type, id, initialScore, initialVote) {
    return {
        score: initialScore,
        userVote: initialVote,
        async vote(voteType) {
            try {
                const response = await fetch('{{ route("vote") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        votable_type: type,
                        votable_id: id,
                        vote_type: voteType
                    })
                });

                const data = await response.json();
                if (data.success) {
                    this.score = data.score;
                    this.userVote = data.user_vote;
                }
            } catch (error) {
                console.error('Vote error:', error);
            }
        }
    }
}
</script>
@endsection