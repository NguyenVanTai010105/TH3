@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@if (session('success_create'))
    <script>
        alert("{{ session('success_create') }}");
    </script>
@elseif(session('success_edit'))
    <script>
        alert("{{ session('success_edit') }}");
    </script>
@elseif(session('success_delete'))
    <script>
        alert("{{ session('success_delete') }}");
    </script>
@endif

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Quản lý bài viết</h1>
        <a href="{{ route('admin.posts.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">+ Thêm bài viết</a>
    </div>

    <div class="overflow-auto rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Tiêu đề</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Slug</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Trạng thái</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Published At</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Lượt xem</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Kho</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Tag</th>
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Hành động</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $post->title }}</td>
                        <td class="px-4 py-2"><code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $post->slug }}</code>
                        </td>
                        <td class="px-4 py-2">
                            <span
                                class="px-2 py-1 rounded 
                            {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-2">{{ $post->view_count }}</td>
                        <td class="p-2 border">
                            {{ $post->category ? $post->category->name : 'Không có' }}
                        </td>
                        <td class="p-2 border">
                            @foreach ($post->tags as $tag)
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 h-full flex gap-2">
                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                class="flex-1 text-center px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium">
                                Sửa
                            </a>

                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full text-center px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 text-sm font-medium">
                                    Xóa
                                </button>
                            </form>
                        </td>



                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Chưa có bài viết.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($posts, 'links'))
        <div class="mt-6">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @endif
@endsection
