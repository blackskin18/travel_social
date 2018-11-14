@extends('common.master')

@section('content')
    @include('user.include.left_menu')
    <!-- Main -->
    @include('user.include.upload_image_popup')

    <div id="main">
        <!-- One -->
        <section id="one">
            <header class="major">
                <h2> Tạo bài viết của bạn</h2>
            </header>
            <textarea class="input-border" name="" id="" cols="30" rows="3"></textarea>
            <ul class="actions">
                <li><a href="#" class="button primary ">Đăng</a></li>
                <li><a href="#" class="button primary" id="btn_create_map">Map</a></li>
                <li><a href="#" class="button primary" id="btn_add_image">Ảnh</a></li>
            </ul>
        </section>


        @include('user.include.article')
        @include('user.include.article')
    </div>

@endsection
@section('head')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('css/style.min.css')  }}" rel="stylesheet">
    <script src="{{ url('js/uploadHBR.min.js')  }}"></script>
@endsection
@section('map')
    @include('user.include.map')
@endsection
