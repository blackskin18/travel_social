@extends('common.master')
@section('content')
    @include('user.include.left_menu', ['friendshipInfo' => $friend_ship_with_current_user, 'user' =>$user_showing])
    <div id="main">
        <h1 class="text-center text-info">
            Danh sách bạn bè
        </h1>
        @foreach($friends as $friendShip)
            @php
                if($friendShip->user_one_id === $user_showing->id) {
                    $friend = $friendShip->userTwo;
                } else {
                    $friend = $friendShip->userOne;
                }
            @endphp
            <div class="row">
                <div class="col-lg-8 offset-lg-2 position-relative">
                    <div>
                        <a href="{{route('user.personal_page', ['id'=>$friend->id])}}">
                            <div class="media border p-3">
                                <img
                                    src=" {{ $friend->avatar ? url('asset/images/avatar/'.$friend->id.'/'.$friend->avatar) : url('asset/images/avatar/default/avatar_default.png') }}"
                                    alt="John Doe" class="ml-5 mr-3 mt-3 rounded-circle" style="width:60px;">
                                <div class="media-body">
                                    <h4 class="pt-4 pl-3"> {{$friend->name}} </h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="position-absolute" style="top: 40px; right: 50px">
                        <div class="dropdown" id="friend_box_{{$friend->id}}">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Bạn bè</button>
                            <div class="dropdown-menu">
                                <button class="btn btn-info dropdown-item btn_cancel_request_add_friend"
                                        data-friend-id="{{$friend->id}}">
                                    Hủy kết bạn
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-info display_none btn_add_friend"
                                id="btn_add_friend_{{$friend->id}}" data-friend-id="{{$friend->id}}">
                            Thêm bạn
                        </button>
                        <div class="dropdown display_none" id="sent_request_box_{{$friend->id}}">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                Đã gửi lời mời kêt bạn
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                                   data-friend-id="{{$friend->id}}">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($users_sent_request as $friendShip)
            @php
                if($friendShip->user_one_id === $user_showing->id) {
                    $user = $friendShip->userTwo;
                } else {
                    $user = $friendShip->userOne;
                }
            @endphp
            <div class="row">
                <div class="col-lg-8 offset-lg-2 position-relative">
                    <div>
                        <a href="{{route('user.personal_page', ['id'=>$user->id])}}">
                            <div class="media border p-3">
                                <img
                                    src=" {{ $user->avatar ? url('asset/images/avatar/'.$user->id.'/'.$user->avatar) : url('asset/images/avatar/default/avatar_default.png') }}"
                                    alt="John Doe" class="ml-5 mr-3 mt-3 rounded-circle" style="width:60px;">
                                <div class="media-body">
                                    <h4 class="pt-4 pl-3"> {{$user->name}} </h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="position-absolute" style="top: 40px; right: 50px">
                        <div class="dropdown" id="reply_friend_request_box">
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
                        <button class="btn btn-info btn_add_friend display_none"
                                id="btn_add_friend_{{$user->id}}" data-friend-id="{{$user->id}}">
                            Thêm bạn
                        </button>
                        <div class="dropdown display_none" id="friend_box_{{$user->id}}">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Bạn bè</button>
                            <div class="dropdown-menu">
                                <button class="btn btn-info dropdown-item btn_cancel_request_add_friend"
                                        data-friend-id="{{$user->id}}">
                                    Hủy kết bạn
                                </button>
                            </div>
                        </div>
                        <div class="dropdown display_none" id="sent_request_box_{{$user->id}}">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                Đã gửi lời mời kêt bạn
                            </button>
                            <div class="dropdown-menu display_none">
                                <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                                   data-friend-id="{{$user->id}}">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($users_receive_request as $friendShip)
            @php
                if($friendShip->user_one_id === $user_showing->id) {
                    $user = $friendShip->userTwo;
                } else {
                    $user = $friendShip->userOne;
                }
            @endphp
            <div class="row">
                <div class="col-lg-8 offset-lg-2 position-relative">
                    <div>
                        <a href="{{route('user.personal_page', ['id'=>$user->id])}}">
                            <div class="media border p-3">
                                <img
                                    src=" {{ $user->avatar ? url('asset/images/avatar/'.$user->id.'/'.$user->avatar) : url('asset/images/avatar/default/avatar_default.png') }}"
                                    alt="John Doe" class="ml-5 mr-3 mt-3 rounded-circle" style="width:60px;">
                                <div class="media-body">
                                    <h4 class="pt-4 pl-3"> {{$user->name}} </h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="position-absolute" style="top: 40px; right: 50px">
                        <button class="btn btn-info btn_add_friend display_none"
                                id="btn_add_friend_{{$user->id}}" data-friend-id="{{$user->id}}">
                            Thêm bạn
                        </button>
                        <div class="dropdown" id="sent_request_box_{{$user->id}}">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                Đã gửi lời mời kêt bạn
                            </button>
                            <div class="dropdown-menu display_none">
                                <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                                   data-friend-id="{{$user->id}}">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($users as $friendShip)
            @php
                if($friendShip->user_one_id === $user_showing->id) {
                    $user = $friendShip->userTwo;
                } else {
                    $user = $friendShip->userOne;
                }
            @endphp
            <div class="row">
                <div class="col-lg-8 offset-lg-2 position-relative">
                    <div>
                        <a href="{{route('user.personal_page', ['id'=>$user->id])}}">
                            <div class="media border p-3">
                                <img
                                    src=" {{ $user->avatar ? url('asset/images/avatar/'.$user->id.'/'.$user->avatar) : url('asset/images/avatar/default/avatar_default.png') }}"
                                    alt="John Doe" class="ml-5 mr-3 mt-3 rounded-circle" style="width:60px;">
                                <div class="media-body">
                                    <h4 class="pt-4 pl-3"> {{$user->name}} </h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if($user->id !== Auth::user()->id)
                    <div class="position-absolute" style="top: 40px; right: 50px">
                        <button class="btn btn-info btn_add_friend"
                                id="btn_add_friend_{{$user->id}}" data-friend-id="{{$user->id}}">
                            Thêm bạn
                        </button>
                        <div class="dropdown display_none" id="sent_request_box_{{$user->id}}">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                Đã gửi lời mời kêt bạn
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item btn_cancel_request_add_friend" href="#"
                                   data-friend-id="{{$user->id}}">Hủy</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach


    </div>
    <script src="{{url('js/search/friend.js')}}"></script>
@endsection
