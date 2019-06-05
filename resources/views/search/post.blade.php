@extends('common.master')


@section('content')
    <div id="main" style="margin: auto">
        <h1 class="text-center text-info">
            Kết quả tìm kiếm bài viết
        </h1>
        @include('post.list_post', ["$posts" => $posts])
    </div>

@endsection
@section('head')

@endsection
@section('map')
    @include('utils.map')
@endsection
