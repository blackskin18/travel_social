@extends('common.master')
@section('content')
    <div class="content_container">
        <form action="{{ route('trip.store') }}" method="POST" id="form_create_trip">
            @csrf
            <div class="form-group">
                <label for="email">Tên chuyến đi:</label>
                <input type="text" name="title" class="form-control"  id="trip_title_input">
            </div>
            <div class="form-group">
                <label for="email">Mô tả chuyến đi:</label>
                <textarea class="input-border" id="post_description" name="description" cols="30"
                          rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian đi: </label>
                <input type="date" name="time_start" class="form-control"  id="time_start_input">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian về: </label>
                <input type="date" name="time_end" class="form-control" id="time_end_input">
            </div>
            <div class="form-group">
                <label for="member"> Mời bạn bè </label>
                <select multiple class="selectpicker" data-show-subtext="true"
                        data-live-search="true" name="member[]">
                    @foreach($users as $user)
                    <option data-subtext="{{$user->email}}"
                            value="{{$user->id}}"> {{ $user->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="hidden_input" id="hidden_input">
                <div id="marker_info_box">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-6">
                <a href="#" class="button w-100" id="btn_create_map">Tạo lịch trình</a>
            </div>
            <div class="col-lg-6">
                <button id="btn_create_trip" class="button primary w-100">Submit</button>
            </div>
        </div>
    </div>

    <script src="{{url("js/trip/create.js")}}"></script>
@endsection
@section('map')
    @include('utils.map')
@endsection
