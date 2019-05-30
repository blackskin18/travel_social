@extends('common.master')
@section('content')
    <div class="content_container">
        <input type="hidden" id="trip_id" value="{{$trip->id}}">
        <div class="row">
            <article class="col-2 col-12-xsmall" style="padding: 0 0 0 2.5em">
                @if($trip->user->avatar)
                    <img style="border-radius: 50%; width:75px; height: 75px "
                         src="{{ url('asset/images/avatar/'.$trip->user->id.'/'.$trip->user->avatar) }}" alt="">
                @else
                    <img style="border-radius: 50%; width:75px; height: 75px "
                         src="{{ url('asset/images/avatar/default/avatar_default.png') }}" alt="">
                @endif
            </article>
            <article class="col-7 col-12-xsmall" style="padding: 0">
                <h2 class="none-padding none-margin">
                    <a href="{{route('user.personal.page', ['id'=>$trip->user_id])}}"
                       style="color: #5cc6a7; text-decoration: none">
                        {{ $trip->user->name }}
                    </a>
                    đã đăng
                    <a href="{{route('post.detail',['id'=>$trip->id])}}">Chuyến đi</a>
                </h2>
                <div class="row">
                    <div class="display_inline_block">
                        <p>
                            {{ $trip->created_at  }}
                        </p>
                    </div>
                    {{--setting button--}}
                    <div class="display_inline_block dropdown dropright" style="padding-left: 5px">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons" style="font-size:24px">settings</i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item btn_show_map" data-trip-id="{{ $trip->id }}">
                                show map
                            </a>
                            <a class="dropdown-item" id="btn_show_member" data-toggle="modal"
                               data-target="#list_member_modal">
                                Thành viên </a>
                            <a class="dropdown-item" id="btn_show_member" data-toggle="modal"
                               data-target="#list_inviting_modal">
                                Danh sách đang mời </a>
                            <a class="dropdown-item" id="btn_show_member" data-toggle="modal"
                               data-target="#list_join_request_modal">
                                Danh sách xin tham gia </a>
                            @if($trip->user_id === Auth::user()->id)
                                <a class="dropdown-item" id="btn_invite_friends" data-toggle="modal" data-target="#myModal">
                                    Mời bạn bè </a>
                                <a class="dropdown-item" href="{{ route('trip.edit', ['trip_id' => $trip->id]) }}"> Sửa </a>
                                <form id="delete_trip_{{$trip->id}}" method="post"
                                      action="{{ route('trip.delete')  }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="trip_id" value="{{$trip->id}}">
                                    <a onclick="document.getElementById('delete_trip_{{$trip->id}}').submit();"
                                       class="dropdown-item">Xóa</a>
                                </form>
                            @else
                                <a class="dropdown-item" id="btn_invite_friends" data-toggle="modal" data-target="#myModal">
                                    Rời khỏi chuyến đi </a>
                            @endif
                        </div>
                    </div>
                </div>

            </article>
        </div>
        {{--end header--}}

        {{--position info--}}
        <div class="hidden_input" id="trip_info_position_{{$trip->id}}">
            @foreach($trip->position as $key => $position)
                <div class="marker_info">
                    <input type="" class="lat_position" value="{{ $position->lat }}">
                    <input type="" class="lng_position" value="{{ $position->lng }}">
                    <input type="" class="marker_description" value="{{ $position->description }}">
                </div>
            @endforeach
        </div>
        <div>
            <h1> {{ $trip->title }} </h1>

            <p>{{ $trip->description }}</p>

            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>Ngày bắt đầu</td>
                    <td>{{ $trip->time_start }}</td>
                </tr>
                <tr>
                    <td>Ngày kết thúc</td>
                    <td>{{ $trip->time_end }}</td>
                </tr>
                </tbody>
            </table>
            <hr>
            @include('trip.include.comment', ['trip'=>$trip])
        </div>
    </div>

    {{--    list join request | modal box--}}
    <div>
        <div class="modal" id="list_join_request_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Danh sách xin tham gia</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <table class="table info">
                            <tbody>
                            @foreach($joinRequests as $joinRequests)
                                <tr id="join_request_{{$joinRequests->user_id}}">
                                    <td  class="p-1">
                                        <a href="{{route('user.personal.page', ['id' => $joinRequests->user_id])}}">
                                            <div class="media">
                                                <img
                                                    src=" {{ $joinRequests->user->avatar ? url('asset/images/avatar/'.$joinRequests->user_id.'/'.$joinRequests->user->avatar) : url('asset/images/avatar/default/avatar_default.png') }}"
                                                    alt="{{$joinRequests->user->name}}" class="mr-3 rounded-circle"
                                                    style="width:60px;">
                                                <div class="media-body">
                                                    <h4 class="p-3"> {{$joinRequests->user->name}} </h4>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    @if($trip->user_id === Auth::user()->id)
                                        <td>
                                            <button class="btn btn-primary btn_accept_join_request"
                                                    data-friend-id="{{$joinRequests->user_id}}"
                                                    data-trip-id="{{$trip->id}}"> Đồng ý
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn_reject_request_join"
                                                    data-friend-id="{{$joinRequests->user_id}}"
                                                    data-trip-id="{{$trip->id}}"> Không đồng ý
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    list user who is inviting | modal box--}}
    <div>
        <div class="modal" id="list_inviting_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Danh sách đang mời</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody>
                            @foreach($invitations as $invitation)
                                @if($invitation->user_id !== $trip->user_id)
                                    <tr id="user_invited_{{$invitation->user_id}}">
                                        <td  class="p-1">
                                            <a href="{{route('user.personal.page', ['id' => $invitation->user->id])}}">
                                                <div class="media">
                                                    <img
                                                        src=" {{ $invitation->user->avatar ? url('asset/images/avatar/'.$invitation->user->id.'/'.$invitation->user->avatar) : url('asset/images/avatar/default/avatar_default.png') }}"
                                                        alt="{{$invitation->user->name}}" class="mr-3 rounded-circle"
                                                        style="width:60px;">
                                                    <div class="media-body">
                                                        <h4 class="p-3"> {{$invitation->user->name}} </h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            {{$invitation->user->email}}
                                        </td>
                                        @if($trip->user_id === Auth::user()->id)
                                            <td>
                                                <button class="delete_member_invited btn btn-danger"
                                                        data-member-id="{{$invitation->user_id}}"
                                                        data-trip-id="{{$trip->id}}">xóa
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    list member | modal box--}}
    <div>
        <div class="modal" id="list_member_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Danh sách thành viên</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <table>
                            <tbody id="table_list_member">
                            @foreach($members as $member)
                                <tr id="member_{{$member->user->id}}">
                                    <td class="p-1">
                                        <a href="{{route('user.personal.page', ['id' => $member->user->id])}}">
                                            <div class="media">
                                                <img
                                                    src="{{$member->user->avatar ? url('asset/images/avatar/'.$member->id.'/'.$member->avatar) : url('asset/images/avatar/default/avatar_default.png')}}"
                                                    alt="{{$member->user->name}}" class="mr-3 rounded-circle"
                                                    style="width:60px;">
                                                <div class="media-body">
                                                    <h4 class="p-3"> {{$member->user->name}} </h4>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    @if($trip->user_id === Auth::user()->id)
                                        <td class="p-1">
                                            <button class="btn btn-danger mb-4 btn_remove_member" data-member-id="{{$member->user->id}}" data-trip-id="{{$trip->id}}"> Xóa</button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- The invite friends | modal box--}}
    <div>
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Mời bạn bè tham gia chuyến đi</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ route('invitation.add')  }}" method="POST"
                              enctype="multipart/form-data" id="invite_friend_form">
                            @csrf
                            <input type="hidden" name="trip_id" value="{{$trip->id}}">
                            <select multiple class="selectpicker" data-show-subtext="true"
                                    data-live-search="true" name="friend_ids[]">
                                @foreach($friends as $friend)
                                    <option data-subtext="{{$friend->email}}"
                                            value="{{$friend->id}}">{{$friend->name}}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <a onclick="document.getElementById('invite_friend_form').submit();"
                           class="btn btn-danger">Mời</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('js/trip/detail.js') }}"></script>
@endsection
@section('map')
    @include('user.include.map')
@endsection
