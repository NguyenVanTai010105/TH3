@extends('layouts.app')
@section('title', 'Tạo Tag mới')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tạo Tag mới</h1>
    
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800">
            💡 Tạo tag mới yêu cầu 
            <strong>{{ config('reputation.requirements.create_tag', 50) }} điểm danh vọng</strong> 
            và mất <strong>{{ config('reputation.costs.create_tag', 10) }} điểm</strong>.
        </p>
        <p class="text-xs text-blue-600 mt-2">
            Điểm hiện tại của bạn: <strong>{{ auth()->user()->reputation }} điểm</strong>
        </p>
    </div>
    
    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Tên Tag</label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name') }}"
                   class="w-full border rounded p-2" 
                   placeholder="Ví dụ: javascript, laravel, php"
                   required>
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        
        <div class="flex items-center justify-between">
            <a href="{{ route('tags.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Quay lại
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tạo Tag (-{{ config('reputation.costs.create_tag', 10) }} điểm)
            </button>
        </div>
    </form>
</div>
@endsection