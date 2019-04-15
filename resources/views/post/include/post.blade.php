<section id="two" class="article">
    {{--header--}}
    @if($post->trip)
        <div class="post_box" style="background: rgba(33,255,64,0.19)">
    @else
        <div class="post_box" style="background: rgba(233, 235, 238,0.26)">
    @endif
        <div class="row">
            <article class="col-2 col-12-xsmall" style="padding: 0 0 0 2.5em">
                @if($post->user->avatar)
                    <img style="border-radius: 50%; width:75px; height: 75px "
                         src="{{ url('asset/images/avatar/'.$post->user->id.'/'.$post->user->avatar) }}" alt="">
                @else
                    <img style="border-radius: 50%; width:75px; height: 75px "
                         src="{{ url('asset/images/avatar/default/avatar_default.png') }}" alt="">
                @endif
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
                    {{--@if($post->user_id == Auth::user()->id)--}}
                    <div class="display_inline_block" style="padding-left: 5px">
                        <a class="post_setting_btn" data-post-id="{{$post->id}}"
                           data-trip-id = "{{$post->trip ? $post->trip->id : null}}"
                           data-post-owner="{{$post->user_id}}"
                           data-auth-user="{{Auth::user()->id}}">
                            <i class="material-icons" style="font-size:24px">settings</i>
                        </a>
                    </div>
                    {{--@endif--}}
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
        <div>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <a class="pointer" id="count_like_in_{{$post->id}}">
                        {{ count($post->like) }} lượt thích
                    </a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                    <a class="pointer" id="count_comment_in_{{$post->id}}">
                        {{ count($post->comment) }} bình luận
                    </a>
                </div>
            </div>
        </div>

        {{--like and comment--}}
        <div>
            <div class="like_box">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        @if($post->be_liked)
                            <div class="text-center btn_like pointer" data-post-id="{{$post->id}}"
                                 style="color: #0ea27a">
                        @else
                            <div class="text-center btn_like pointer" data-post-id="{{$post->id}}">
                            @endif
                                <i class='far fa-thumbs-up'></i>
                                Like
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="text-center btn_comment pointer" data-article-id="{{$post->id}}"> Bình luận
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment_box display_none" id="comment_box_{{$post->id}}">
                    <div class="row comment_input_box">
                        <div class="avatar_comment_box col-lg-1">
                            @if(Auth::user()->avatar)
                                <img class="avatar_image"
                                     src="{{ url('asset/images/avatar/'.Auth::user()->id.'/'.Auth::user()->avatar) }}"
                                     alt="">
                            @else
                                <img class="avatar_image"
                                     src="{{ url('asset/images/avatar/default/avatar_default.png') }}"
                                     alt="">
                            @endif
                        </div>
                        <div class="col-lg-10">
                            <input type="text" class="comment_input" data-article-id="{{$post->id}}">
                        </div>
                    </div>
                    <div class="list_comment">
                    </div>
                </div>
            </div>
        </div>

    {{-- end like and comment--}}
</section>
