<style>
    #header {
        background-image: url({{ url('asset/images/cover/'.$user->cover) }}), url(../../images/bg.jpg);
    }
</style>
<header id="header">
    <div>
        <div style="display: inline-block; position: absolute; top: 0; left: 2.5em;">
            <div class="display_inline_block">
                @if($user->id !== Auth::user()->id)
                    <button class="btn btn-info {{!$friendshipInfo || $friendshipInfo->type === 2 ? : "display_none"}} "
                            id="btn_add_friend" data-friend-id="{{$user->id}}">
                        Thêm bạn
                    </button>
                    <div
                        class="dropdown {{$friendshipInfo && $friendshipInfo->type === 0 &&  $friendshipInfo->user_one_id === Auth::user()->id ? : "display_none"}}"
                        id="sent_request_box">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
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
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
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
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            Bạn bè
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                               data-friend-id="{{$user->id}}">Hủy kết bạn</a>
                        </div>
                    </div>
                </div>
            @endif

            <a class="btn btn-info" href="{{ route('user.list_friend', $user->id) }}">
                danh sách bạn bè
            </a>
            <a class="btn btn-info" href="{{ route('detail.info', $user->id) }}">
                    Thông tin
            </a>
        </div>
    </div>
    <div class="inner avatar_display">
        @include('user.include.upload_avatar')
        <a href="{{route('user.personal_page', ['id' => $user->id])}}">
            <h1><strong>{{ $user->name  }}</strong></h1>
        </a>
    </div>
</header>
<script src="{{url('js/User/include/left_menu.js')}}"></script>
