@extends('layouts.app')

@section('title', 'Quản lý bài viết')

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
                    <th class="px-4 py-2 text-center font-medium text-gray-700">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($posts as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $p->title }}</td>
                        <td class="px-4 py-2"><code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $p->slug }}</code>
                        </td>
                        <td class="px-4 py-2">
                            <span
                                class="px-2 py-1 rounded 
                            {{ $p->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $p->published_at ? $p->published_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-2">{{ $p->view_count }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.posts.edit', $p->id) }}"
                                class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Sửa</a>
                            <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs"
                                    type="submit">Xóa</button>
                            </form>
                            <a href="{{ route('posts.show', $p->slug) }}"
                                class="px-2 py-1 border border-gray-300 text-gray-700 rounded hover:bg-gray-100 text-xs"
                                target="_blank">Xem</a>
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
