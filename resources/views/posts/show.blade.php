@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1></h1>
            <div class="text-muted mb-3">
                Đăng:
                — Lượt xem:
            </div>

            <div class="mb-4"></div>

            <a href="" class="btn btn-outline-secondary">⬅ Quay lại</a>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6>Tùy chọn</h6>
                    <p class="mb-0">Chia sẻ / bình luận (nếu có thể thêm sau).</p>
                </div>
            </div>
        </div>
    </div>
@endsection
