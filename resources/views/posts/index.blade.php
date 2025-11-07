@extends('layouts.app')

@section('title', 'Tin tức')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Tin tức mới nhất</h1>


            <article class="mb-4">
                <h3><a href=""></a></h3>
                <div class="text-muted mb-1">
                    —
                    Lượt xem:
                </div>
                <p class="post-excerpt">

                </p>
                <a class="btn btn-sm btn-outline-primary" href="">Đọc tiếp</a>
                <hr>
            </article>





        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tìm kiếm</h5>
                    <form action="" method="GET">
                        <input type="text" name="q" class="form-control"
                            placeholder="Tìm theo tiêu đề hoặc nội dung" value="">
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6>Thông tin</h6>
                    <p class="mb-0">Demo Blog theo đề TH4 — CRUD, slug, đếm view.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
