@extends('common.master')

@section('content')
    @include('user.include.left_menu', ['friendshipInfo', $friendshipInfo])
    <div id="main">
        @if($user->id === Auth::User()->id)
            <section id="one">
                <header class="major">
                    <h2> Tạo bài viết của bạn</h2>
                </header>
                @include('include.create_post')
            </section>
        @endif
        @include('post.include.list_post', ["$posts" => $posts])
    </div>
@endsection
@section('map')
    @include('user.include.map')
@endsection
