@extends('common.master')
@section('content')
    <div class="content_container">
        <h1>Danh sách các chuyến đi</h1>
        <div id="accordion">
            <div class="card">
                <a class="card-link btn-light" data-toggle="collapse" href="#trip_created_by_user">
                    <div class="card-header text-center">
                        Các chuyến đi đã tạo
                    </div>
                </a>
                <div id="trip_created_by_user" data-parent="#accordion" class="collapse show">
                    <table class="table">
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
            </div>
            <div class="card">
                <a class="card-link btn-light" data-toggle="collapse" href="#trip_user_invited">
                    <div class="card-header text-center">
                        Các chuyến đi được mời
                    </div>
                </a>
                <div id="trip_user_invited" data-parent="#accordion" class="collapse">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Ngày tạo</th>
                                <th>Người tạo</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invitations as $invitation)
                                <tr id="invitation_trip_{{$invitation->trip_id}}">
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
                                        <button class="btn btn-primary btn_accept_invitation"
                                                data-trip-id="{{$invitation->trip_id}}"> Đồng ý
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn_reject_invitation"
                                                data-trip-id="{{$invitation->trip_id}}"> Xóa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <a class="card-link btn-light" data-toggle="collapse" href="#trip_user_joining">
                    <div class="card-header text-center">
                        Các chuyến đi đang tham gia
                    </div>
                </a>
                <div id="trip_user_joining" data-parent="#accordion" class="collapse">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Ngày tạo</th>
                                <th>Người tạo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($joiningTrips as $joiningTrip)
                                <tr id="joining_trip_{{$joiningTrip->trip_id}}">
                                    <td>
                                        <a href="{{ route('trip.detail', $joiningTrip->trip->id) }}">
                                            {{ $joiningTrip->trip->title }}
                                        </a>
                                    </td>
                                    <td>{{ $joiningTrip->trip->created_at }}</td>
                                    <td>
                                        <a href="{{ route('user.personal.page', $joiningTrip->trip->user->id) }}">
                                            {{ $joiningTrip->trip->user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn_leave_trip"
                                                data-trip-id="{{$joiningTrip->trip_id}}"> Rời khỏi
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="{{url('js/trip/list.js')}}"></script>
@endsection
