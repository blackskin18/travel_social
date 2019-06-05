@extends('common.master')
@section('content')
    <div class="content_container">
        <form action="{{ route('trip.update', ['trip_id'=>$trip->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="email">Tên chuyến đi:</label>
                <input type="text" name="title" class="form-control" id="title" value="{{$trip->title}}">
            </div>
            <div class="form-group">
                <label for="email">Mô tả chuyến đi:</label>
                <textarea class="input-border" id="post_description" name="description" cols="30"
                          rows="3">
{{$trip->description}}
                </textarea>
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian đi: </label>
                <input type="date" name="time_start" class="form-control"  value="{{$trip->time_start}}">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian về: </label>
                <input type="date" name="time_end" class="form-control" value="{{$trip->time_end}}">
            </div>
            <div class="hidden_input" id="hidden_input">
                <div id="marker_info_box">
                    @foreach($trip->position as $key => $position)
                        <div class="marker_info">
                            <input type="hidden" name="lat[]" class="lat_position" value="{{$position->lat}}">
                            <input type="hidden" name="lng[]" class="lng_position" value="{{$position->lng}}">
                            <input type="hidden" name="marker_description[]" class="marker_description"
                                   value="{{$position->description}}">
                            <input type="datetime-local" name="time_arrive[]" class="time_arrive" value="{{ $position->time_arrive ? date('Y-m-d\TH:i:s', strtotime($position->time_arrive)) : ''}}">
                            <input type="datetime-local" name="time_leave[]" class="time_leave" value="{{ $position->time_arrive ? date('Y-m-d\TH:i:s', strtotime($position->time_leave)) : ''}}">
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <a href="#" class="btn btn-primary" id="btn_create_map">Map</a>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="{{url("js/trip/edit.js")}}"></script>
@endsection
@section('map')
    @include('utils.map')
@endsection
