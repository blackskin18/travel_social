<style>
    #header {
        background-image: url({{ url('asset/images/cover/'.$user->id.'/'.$user->cover) }}), url(../../images/bg.jpg);
    }
</style>
<header id="header">
    <div>
        <div style="display: inline-block; position: absolute; top: 0; left: 2.5em;">
            {{--            @if(!$friendshipInfo || $friendshipInfo->type === 2)--}}
            {{--                <button class="btn btn-light" id="btn_add_friend" data-friend-id="{{$user->id}}">--}}
            {{--                    Thêm bạn--}}
            {{--                </button>--}}
            {{--                <div class="dropdown display_none" id="btn_friendship_action">--}}
            {{--                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">--}}
            {{--                        Đã gửi lời mời kêt bạn--}}
            {{--                    </button>--}}
            {{--                    <div class="dropdown-menu">--}}
            {{--                        <a class="dropdown-item" href="#" id="btn_remove_request_add_friend"--}}
            {{--                           data-friend-id="{{$user->id}}">Hủy</a>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            @elseif($friendshipInfo && $friendshipInfo->type === 0)--}}
            {{--                @if($friendshipInfo->user_one_id === Auth::user()->id)--}}
            {{--                    <button class="btn btn-light display_none" id="btn_add_friend" data-friend-id="{{$user->id}}">--}}
            {{--                        Thêm bạn--}}
            {{--                    </button>--}}
            {{--                    <div class="dropdown " id="btn_friendship_action">--}}
            {{--                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">--}}
            {{--                            Đã gửi lời mời kêt bạn--}}
            {{--                        </button>--}}
            {{--                        <div class="dropdown-menu">--}}
            {{--                            <a class="dropdown-item" href="#" id="btn_remove_request_add_friend"--}}
            {{--                               data-friend-id="{{$user->id}}">Hủy</a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                @elseif($friendshipInfo->user_two_id === Auth::user()->id)--}}
            <button class="btn btn-light {{!$friendshipInfo || $friendshipInfo->type === 2 ? : "display_none"}} "
                    id="btn_add_friend" data-friend-id="{{$user->id}}">
                Thêm bạn
            </button>
            <div
                class="dropdown {{$friendshipInfo && $friendshipInfo->type === 0 &&  $friendshipInfo->user_one_id === Auth::user()->id ? : "display_none"}}"
                id="sent_request_box">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                    Đã gửi lời mời kêt bạn
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                       data-friend-id="{{$user->id}}">Hủy</a>
                </div>
            </div>
            <div
                class="dropdown {{$friendshipInfo && $friendshipInfo->type === 0 &&  $friendshipInfo->user_two_id === Auth::user()->id ? : "display_none"}}"
                id="reply_friend_request_box">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                    Trả lời lời mời kết bạn
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item btn_accept_add_friend_request" href="#"
                       data-friend-id="{{$user->id}}">Đồng ý</a>
                    <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                       data-friend-id="{{$user->id}}">Không đồng ý</a>
                </div>
            </div>
            <div
                class="dropdown {{$friendshipInfo && $friendshipInfo->type === 1 ? : "display_none"}}"
                id="is_friend_box">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                    Bạn bè
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                       data-friend-id="{{$user->id}}">Hủy kết bạn</a>
                </div>
            </div>
            {{--                @endif--}}
            {{--            @endif--}}
        </div>
    </div>
    <div class="inner avatar_display">
        @include('user.include.upload_avatar')
        <a href="{{route('user.personal.page', ['id' => $user->id])}}">
            <h1><strong>{{ $user->name  }}</strong></h1>
        </a>
    </div>
    <div class="more-info">
        <div class="album">
            album
        </div>
        <a href="{{ route('detail.info', $user->id) }}">
            <div class="detail-info">
                Thông tin
            </div>
        </a>
        <div class="list-friend">
            Bạn bè
        </div>
    </div>
</header>
<script src="{{url('js/User/include/left_menu.js')}}"></script>
