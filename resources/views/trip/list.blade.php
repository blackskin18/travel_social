@extends('common.master')
@section('content')
    <div class="content_container">
        <h1>Danh sách các chuyến đi</h1>
        <button type="button" class="btn btn-primary" data-toggle="collapse"
                data-target="#trip_created_by_user,#trip_user_follow">toggle
        </button>
        <div id="trip_created_by_user" class="collapse show">
            <h2>Các chuyến đi đã tạo</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Ngày tạo</th>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </br>
        <div id="trip_user_follow" class="collapse">
            <h2>Các chuyến đi đang theo dõi</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Tên</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tripsUserFollow as $tripUserFollow)
                    <tr>
                        <td>
                            <a href="{{ route('trip.detail', $tripUserFollow->trip->id) }}">
                                {{ $tripUserFollow->trip->title }}
                            </a>
                        </td>
                        <td>{{ $tripUserFollow->trip->created_at }}</td>
                        <td>
                            <a href="{{ route('personal.page', $tripUserFollow->trip->user->id) }}">
                                {{ $tripUserFollow->trip->user->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
