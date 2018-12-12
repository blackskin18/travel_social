@foreach($articles as $article)
    <section id="two" class="article">
        <div class="row">
            <article class="col-2 col-12-xsmall" style="padding: 0 0 0 2.5em">
                <img style="border-radius: 50%; width:75px; height: 75px "
                     src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}" alt="">
            </article>
            <article class="col-7 col-12-xsmall" style="padding: 0">
                <h2 class="none-padding none-margin">
                    <a href="" style="color: #5cc6a7; text-decoration: none">
                        {{ $user->name }}
                    </a>
                    đã đăng bài viết
                </h2>
                <p>
                    {{ $article->created_at  }}
                </p>
            </article>
            <article class="col-3 col-12-xsmall">
                <button class="button primary btn_show_map" data-post-id="{{ $article->id }}"> show map</button>
            </article>
        </div>
        <div class="hidden_input" id="article_info_position_{{$article->id}}">
            @foreach($article->position as $key => $position)
                <div class="marker_info">
                    <input type="" class="lat_position" value="{{ $position->lat }}">
                    <input type="" class="lng_position" value="{{ $position->lng }}">
                    <input type="" class="marker_description" value="{{ $position->description }}">
                </div>
            @endforeach
        </div>
        <div class="">
            {!! $article->description !!}
        </div>

        <div class="row image_list" id="image_list_{{$article->id}}">
            @foreach($article->postImage as $key => $image)
                <div class="col-6 col-12-xsmall work-item">
                    <a class="image fit image_showed" data-post-id="{{$article->id}}" data-index="{{$key}}">
                        <img src="{{ url('/storage/post/'.$image->post_id.'/'.$image->image) }}" alt=""/>
                    </a>
                </div>
            @endforeach
        </div>
        {{--<div class="row">--}}
        <div class="like_box">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-center btn_like"> Like</div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center btn_comment" data-article-id="{{$article->id}}"> Bình luận</div>
                </div>
            </div>
        </div>
        <div class="comment_box display_none" id="comment_box_{{$article->id}}">
            <div class="row comment_input_box">
                <div class="avatar_comment_box col-lg-1">
                    <img class="avatar_image" src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}"
                         alt="">
                </div>
                <div class="col-lg-10">
                    <input type="text" class="comment_input" data-article-id="{{$article->id}}">
                </div>
            </div>
            <div class="list_comment">
            </div>
        </div>
        {{--</div>--}}

    </section>
@endforeach

{{--<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
<script src="{{ url('js/User/Include/article.js') }}"></script>
<script>
    $(document).ready(function () {
        var socket = io.connect('http://127.0.0.1:8890');
        console.log('connected..');
        socket.on('message', function (data) {
            data = $.parseJSON(data);
            var commentElement = `
                        <div class="row">
                            <div class="avatar_comment_box col-lg-1">
                                <img class="avatar_image" src="${window.location.origin}/asset/images/avatar/${data.user_id}/${data.user_avatar}" alt="">
                            </div>
                                <div class="comment">
                                    <a href="/user/personal-page/${data.user_id}">
                                        ${data.user_name}
                                    </a>
                                    <div style="display: inline-block;">
                                        <p>${data.comment}</p>
                                    </div>
                                </div>
                        </div>`;
            $("div#comment_box_" + data.post_id+">.list_comment").prepend(commentElement);
        });
    });
</script>
