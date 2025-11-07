<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Blog')</title>

</head>


<body class="flex flex-col min-h-screen bg-gray-50">
    @include('components.header')
    {{-- <nav class="mb-4">
        <a href="{{ route('posts.index') }}">Trang chủ</a> |
        <a href="{{ route('admin.posts.index') }}">Admin</a>
    </nav> --}}
    <div class=" grow container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
    @include('components.footer')
</body>


</html>
