@extends('common.master')
@section('content')
    <div class="content_container">
        <h1>Danh sách các chuyến đi</h1>
        <button type="button" class="btn btn-primary" data-toggle="collapse"
                data-target="#trip_created_by_user,#trip_user_follow"> Đã tạo
        </button>
        <button type="button" class="btn btn-primary" data-toggle="collapse"
                data-target="#trip_created_by_user,#trip_user_follow">Được mời
        </button>
        <button type="button" class="btn btn-primary" data-toggle="collapse"
                data-target="#trip_created_by_user,#trip_user_follow">Xin tham gia
        </button>

        <div id="trip_created_by_user" class="collapse show">
            <h2>Các chuyến đi đã tạo</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Tên</th>
                    <th>Ngày tạo</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tripsCreateByUser as $tripCreateByUser)
                    <tr>
                        <td>
                            <a href="{{route('trip.detail', $tripCreateByUser->id)}}">
                                {{ $tripCreateByUser->title }}
                            </a>
                        </td>
                        <td>{{ $tripCreateByUser->created_at }}</td>
                        <td>
                            <form id="delete_trip_{{$tripCreateByUser->id}}" method="post"
                                  action="{{ route('trip.delete')  }}">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="trip_id" value="{{$tripCreateByUser->id}}">
                                <a onclick="document.getElementById('delete_trip_{{$tripCreateByUser->id}}').submit();"
                                   class="btn btn-danger">Xóa</a>
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-primary">Xửa</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </br>
        <div id="trip_user_follow" class="collapse">
            <h2>Các chuyến đi được mời</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Tên</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Trạng thái</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($invitations as $invitation)
                    <tr>
                        <td>
                            <a href="{{ route('trip.detail', $invitation->trip->id) }}">
                                {{ $invitation->trip->title }}
                            </a>
                        </td>
                        <td>{{ $invitation->trip->created_at }}</td>
                        <td>
                            <a href="{{ route('user.personal.page', $invitation->trip->user->id) }}">
                                {{ $invitation->trip->user->name }}
                            </a>
                        </td>
                        <td>
                            @if($invitation->accepted)
                                Đồng ý tham gia
                            @else
                                Không thao gia
                            @endif
                        </td>
                        <td>
                            <form id="accept_invitation_trip_{{$invitation->trip_id}}" method="post"
                                  action="{{ route('invitation.accept')  }}">
                                @csrf
                                <input type="hidden" name="trip_id" value="{{$invitation->trip_id}}">
                                @if($invitation->accepted)
                                    <a onclick="document.getElementById('accept_invitation_trip_{{$invitation->trip_id}}').submit();"
                                       class="btn btn-warning">Không Tham gia
                                    </a>
                                @else
                                    <a onclick="document.getElementById('accept_invitation_trip_{{$invitation->trip_id}}').submit();"
                                        class="btn btn-primary">Đồng ý
                                    </a>
                                @endif
                            </form>
                        </td>
                        <td>
                            <form id="delete_invitation_trip_{{$invitation->trip_id}}" method="post"
                                  action="{{ route('invitation.delete')  }}">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="trip_id" value="{{$invitation->trip_id}}">
                                <a onclick="document.getElementById('delete_invitation_trip_{{$invitation->trip_id}}').submit();"
                                   class="btn btn-danger">Xóa</a>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
