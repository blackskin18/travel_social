<section id="two" class="article">
    {{--header--}}
    <div class="row">
        <article class="col-2 col-12-xsmall" style="padding: 0 0 0 2.5em">
            <img style="border-radius: 50%; width:75px; height: 75px "
                 src="{{ url('asset/images/avatar/'.$post->user->id.'/'.$post->user->avatar) }}" alt="">
        </article>
        <article class="col-7 col-12-xsmall" style="padding: 0">
            <h2 class="none-padding none-margin">
                <a href="{{route('personal.page', ['id'=>$post->user_id])}}"
                   style="color: #5cc6a7; text-decoration: none">
                    {{ $post->user->name }}
                </a>
                đã đăng
                <a href="{{route('post.detail',['id'=>$post->id])}}">bài viết</a>
            </h2>
            <div class="row">
                <div class="display_inline_block">
                    <p>
                        {{ $post->created_at  }}
                    </p>
                </div>
                <div class="display_inline_block" style="padding-left: 5px">
                    <a class="post_setting_btn" data-post-id="{{$post->id}}">
                        <i class="material-icons" style="font-size:24px">settings</i>
                    </a>
                </div>
            </div>

        </article>
        <article class="col-3 col-12-xsmall">
            <button class="button primary btn_show_map" data-post-id="{{ $post->id }}"> show map</button>
        </article>
    </div>
    {{--end header--}}

    {{--position info--}}
    <div class="hidden_input" id="article_info_position_{{$post->id}}">
        @foreach($post->position as $key => $position)
            <div class="marker_info">
                <input type="" class="lat_position" value="{{ $position->lat }}">
                <input type="" class="lng_position" value="{{ $position->lng }}">
                <input type="" class="marker_description" value="{{ $position->description }}">
            </div>
        @endforeach
    </div>
    {{--end positon info--}}

    {{--description--}}
    <div class="">
        {!! $post->description !!}
    </div>
    {{--end description--}}

    {{--list image--}}
    <div class="row image_list" id="image_list_{{$post->id}}">
        @foreach($post->post_image as $key => $image)
            <div class="col-6 col-12-xsmall work-item">
                <a class="image fit image_showed" data-post-id="{{$post->id}}" data-index="{{$key}}">
                    <img src="{{ url('/storage/post/'.$image->post_id.'/'.$image->image) }}" alt=""/>
                </a>
            </div>
        @endforeach
    </div>
    {{--end list image--}}

    {{--like and comment--}}
    <div>
        <div class="like_box">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-center btn_like"> Like</div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center btn_comment" data-article-id="{{$post->id}}"> Bình luận</div>
                </div>
            </div>
        </div>
        <div class="comment_box display_none" id="comment_box_{{$post->id}}">
            <div class="row comment_input_box">
                <div class="avatar_comment_box col-lg-1">
                    <img class="avatar_image"
                         src="{{ url('asset/images/avatar/'.Auth::user()->id.'/'.Auth::user()->avatar) }}"
                         alt="">
                </div>
                <div class="col-lg-10">
                    <input type="text" class="comment_input" data-article-id="{{$post->id}}">
                </div>
            </div>
            <div class="list_comment">
            </div>
        </div>
    </div>
    {{-- end like and comment--}}
</section>
