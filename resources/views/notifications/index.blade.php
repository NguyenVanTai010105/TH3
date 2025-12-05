@extends('layouts.app')
@section('title', 'Thông báo')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h1 class="text-2xl font-bold">Thông báo</h1>
        @if($notifications->where('read_at', null)->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button class="text-blue-600 hover:underline">Đánh dấu tất cả đã đọc</button>
            </form>
        @endif
    </div>
    <div class="divide-y">
        @forelse($notifications as $notification)
            <div class="p-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                    @csrf
                    <button class="text-left w-full">
                        <p class="font-medium">{{ $notification->data['message'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </button>
                </form>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">Không có thông báo</div>
        @endforelse
    </div>
    <div class="p-6">{{ $notifications->links() }}</div>
</div>
@endsection