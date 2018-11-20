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
                <input type="button" id="test" class="button primary" value="test">

            </form>

        </section>
        @foreach($articles as $article)
            @include('user.include.article', ["article" => $article])
        @endforeach
    </div>

@endsection
@section('head')
    <script src="{{ url('js/article.js')  }}"></script>
@endsection
@section('map')
    @include('user.include.map')
@endsection
