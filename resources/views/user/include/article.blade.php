<section id="two">
    <div class="row">
        <article class="col-2 col-12-xsmall" style="padding: 0 0 0 2.5em">
            <img style="border-radius: 50%; width:75px; height: 75px "
                 src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}" alt="">
        </article>
        <article class="col-10 col-12-xsmall" style="padding: 0">
            <h2 class="none-padding none-margin">
                <a href="" style="color: #5cc6a7; text-decoration: none">
                    {{ $user->name }}
                </a>
                đã đăng bài viết
            </h2>
            <p>
                31 Tháng 10 lúc 20:54
            </p>
        </article>
    </div>
    <div class="">
        {{ $article->description  }}
    </div>

    <div class="row">
        @foreach($article->postImage as $key => $image)
            <article class="col-4 col-12-xsmall work-item">
                <a href="images/fulls/01.jpg" class="image fit"><img src="{{ url($image->image) }}"
                                                                     alt=""/></a>
            </article>
        @endforeach
    </div>
    <ul class="actions">
        <li><a href="#" class="button">Full Portfolio</a></li>
    </ul>
</section>
