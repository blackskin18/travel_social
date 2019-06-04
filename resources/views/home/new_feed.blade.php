@extends('common.master')

@section('content')
    <div id="main" style="margin: auto">
        <section id="one">
            <header class="major">
                <h2> Tạo bài viết của bạn</h2>
            </header>
            @include('include.create_post')
        </section>
        @include('post.include.list_post', ["$posts" => $posts])
    </div>
@endsection
@section('head')

@endsection
@section('map')
    @include('user.include.map')
@endsection
