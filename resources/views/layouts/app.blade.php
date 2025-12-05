<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .markdown-content h1 { font-size: 2em; font-weight: bold; margin: 1em 0 0.5em; }
        .markdown-content h2 { font-size: 1.5em; font-weight: bold; margin: 0.8em 0 0.4em; }
        .markdown-content code { background: #f3f4f6; padding: 0.2em 0.4em; border-radius: 3px; }
        .markdown-content pre { background: #1f2937; color: #fff; padding: 1em; border-radius: 5px; overflow-x: auto; }
        .markdown-content pre code { background: none; padding: 0; }
        .best-answer { border-left: 4px solid #10b981; background-color: #f0fdf4; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a href="{{ route('questions.index') }}" class="flex items-center text-xl font-bold text-blue-600">
                        🎯 Forum Q&A
                    </a>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                        <a href="{{ route('questions.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                            Câu hỏi
                        </a>
                        <a href="{{ route('tags.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                            Tags
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Notifications Bell -->
                        <div class="relative" x-data="{ open: false, count: {{ auth()->user()->unreadNotifications->count() }} }">
                            <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span x-show="count > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full" x-text="count"></span>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto">
                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="font-bold">Thông báo</h3>
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <form action="{{ route('notifications.read-all') }}" method="POST">
                                                @csrf
                                                <button class="text-sm text-blue-600 hover:underline">Đánh dấu tất cả</button>
                                            </form>
                                        @endif
                                    </div>
                                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                        <div class="border-b py-2">
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                <button class="text-left w-full hover:bg-gray-50 p-2 rounded">
                                                    <p class="text-sm">{{ $notification->data['message'] }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-sm">Không có thông báo mới</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('questions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Đăng câu hỏi
                        </a>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('users.profile', auth()->user()) }}" class="flex items-center space-x-2 hover:bg-gray-100 px-3 py-2 rounded">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">⭐ {{ auth()->user()->reputation }} điểm</p>
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="text-sm text-gray-600 hover:text-gray-900">Đăng xuất</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>