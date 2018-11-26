<section id="two">
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

    <div class="row">
        @foreach($article->postImage as $key => $image)
            <article class="col-6 col-12-xsmall work-item">
                <a href="{{ url($image->image) }}" class="image fit"><img src="{{ url($image->image) }}" alt=""/></a>
            </article>
        @endforeach
    </div>
    <div class="comment-box">
    </div>
</section>
