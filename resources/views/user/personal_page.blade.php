@extends('common.master')

@section('content')
    @include('user.include.left_menu')

    <div id="main">
        <section id="one">
            <header class="major">
                <h2> Tạo bài viết của bạn</h2>
            </header>
            <form action="{{ route('post.create')  }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="hidden_input" id="hidden_input">
                    <div id="marker_info_box">
                    </div>
                </div>
                <div style="margin-bottom: 20px">
                    <textarea class="input-border" id="post_description" name="post_description" cols="30"
                              rows="3"></textarea>
                    <ul class="actions" style="margin-bottom: 0px; height: 50px">
                        <li><a href="#" class="button" id="btn_create_map">Map</a></li>
                        <li>
                            <div class="upload-btn-wrapper">
                                <button class="button">Upload a file</button>
                                <input type="file" name="photos[]" multiple accept="image/x-png,image/jpeg"/>
                            </div>
                        </li>
                    </ul>
                </div>

                <input type="submit" class="button primary" value="Đăng">
                {{-- <input type="button" id="test" class="button primary" value="test"> --}}

            </form>

        </section>
        @foreach($articles as $article)
            @include('user.include.article', ["article" => $article])
        @endforeach
        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>

        {{--<script src="{{asset('js/socket.io.js')}}"></script>--}}
        <script>
            // $(document).ready(function () {
            //     var socket = io.connect('http://127.0.0.1:8890');
            //     console.log('connected..');
            //     socket.on('message', function (data) {
            //         $('#message').append("<p>" + data + "</p>");
            //     });
            // });
        </script>
    </div>

@endsection
@section('head')
    <script src="{{ url('js/User/article.js') }}"></script>
    {{--<script src="{{ url('js/article.js')  }}"></script>--}}
@endsection
@section('map')
    @include('user.include.map')
@endsection
