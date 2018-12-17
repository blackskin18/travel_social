@extends('common.master')

@section('content')
    <div id="main" style="margin: auto">
        @include('post.include.post', ["post" => $post])
    </div>

    {{--comment real time--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
    <script src="{{ url('js/User/Include/article.js') }}"></script>
@endsection
@section('head')

@endsection
@section('map')
    @include('user.include.map')
@endsection
