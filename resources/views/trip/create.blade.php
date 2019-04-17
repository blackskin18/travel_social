@extends('common.master')
@section('content')
    <div class="content_container">
        <form action="{{ route('trip.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Tên chuyến đi:</label>
                <input type="text" name="title" class="form-control" id="title">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian đi: </label>
                <input type="date" name="time_start" class="form-control" id="pwd">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian về: </label>
                <input type="date" name="time_end" class="form-control" id="pwd">
            </div>
            <div class="form-group form-check">
                <label class="form-group"> Thành viên: </label>
                <select name="member[]" multiple>
                    @foreach($users as $user)
                        <option value="{{$user->id}}"> {{ $user->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="hidden_input" id="hidden_input">
                <div id="marker_info_box">
                </div>
            </div>
            <div>
                <a href="#" class="btn btn-primary" id="btn_create_map">Map</a>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="{{url("js/trip/create.js")}}"></script>
@endsection
@section('map')
    @include('user.include.map')
@endsection
