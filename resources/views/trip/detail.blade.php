@extends('common.master')
@section('content')
    <div class="content_container">
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
                    <a href="{{route('post.detail',['id'=>$trip->id])}}">bài viết</a>
                </h2>
                <div class="row">
                    <div class="display_inline_block">
                        <p>
                            {{ $trip->created_at  }}
                        </p>
                    </div>
                    {{--@if($post->user_id == Auth::user()->id)--}}
                    <div class="display_inline_block" style="padding-left: 5px">
                        <a class="post_setting_btn">
                            <i class="material-icons" style="font-size:24px">settings</i>
                        </a>
                        </a>
                    </div>
                    {{--@endif--}}
                </div>

            </article>
            <article class="col-3 col-12-xsmall">
                <button class="button primary btn_show_map" data-trip-id="{{ $trip->id }}"> show map</button>
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
            <h1> Thành viên </h1>
            <table class="table table-striped">
                <tbody>
                @foreach($invitations as $invitation)
                    @if($invitation->user_id !== $trip->user_id)
                        <tr id="user_invited_{{$invitation->user_id}}">
                            <td>
                                <a href="{{route('user.personal.page', ['id' => $invitation->user->id])}}">
                                    {{ $invitation->user->name }}
                                </a>
                            </td>
                            <td>{{ $invitation->user->email }}</td>
                            <td>
                                @if($invitation->user_id === Auth::user()->id)
                                    @if($invitation->accepted)
                                        Sẽ tham gia
                                        <form action="{{ route('invitation.accept')  }}" class="none-margin"
                                              method="post">
                                            @csrf
                                            <input type="hidden" name="trip_id" value="{{$invitation->trip_id}}">
                                            <input type="submit" class="button small" value="Hủy">
                                        </form>
                                    @else
                                        <form action="{{ route('invitation.accept')  }}" class="none-margin"
                                              method="post">
                                            @csrf
                                            <input type="hidden" name="trip_id" value="{{$invitation->trip_id}}">
                                            <input type="submit" class="button small" value="Tham gia">
                                        </form>
                                    @endif
                                @else
                                    @if($invitation->accepted)
                                        Sẽ tham gia
                                    @else
                                        Đang đợi xác nhận
                                    @endif
                                @endif
                            </td>
                            @if($trip->user_id === Auth::user()->id && $invitation->user_id !== Auth::user()->id)
                                <td>
                                    <button class="delete_member_invited" data-member-id="{{$invitation->user_id}}"
                                            data-trip-id="{{$trip->id}}">xóa
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h1>Danh sách xin tham gia</h1>
            <table class="table info">
                <thead>
                    <tr>
                        <th>tên</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($trip->joinRequestUser as $joinRequestUser)
                    <tr>
                        <td>
                            <a href="{{route('user.personal.page', ['id' => $joinRequestUser->id])}}">
                                {{$joinRequestUser->name}}
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-primary btn_accept_request_join" data-user-join-id="{{$joinRequestUser->id}}"
                                    data-trip-id="{{$trip->id}}"> Đồng ý </button>
                        </td>
                        <td>
                            <button class="btn btn-danger btn_reject_request_join" data-user-join-id="{{$joinRequestUser->id}}"
                                    data-trip-id="{{$trip->id}}"> Không đồng ý </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ url('js/trip/detail.js') }}"></script>
@endsection
@section('map')
    @include('user.include.map')
@endsection
