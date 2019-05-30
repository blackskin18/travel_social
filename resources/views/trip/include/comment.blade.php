<br>
<div class="comment_box" id="comment_box_{{$trip->id}}">
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
            <input type="text" class="comment_input" data-article-id="{{$trip->id}}">
        </div>
    </div>
    <div class="list_comment">
    </div>
</div>
