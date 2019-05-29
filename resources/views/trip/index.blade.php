@extends('common.master')

@section('content')
    <input type="hidden" id="firebase_token" value="{{ $firebase_token }}">
    <div class="content_container">
        <div class="text-center">
            <a href="{{Route('trip.show', ['id' => $trip->id])}}">
                <h1>
                    {{$trip->title}}
                </h1>
            </a>

        </div>
        <div id="map" style="width: 100%; height: 500px;">

        </div>
        <div class="hidden_input" id="position_info">
            @foreach($trip->position as $key => $position)
                <div class="marker_info">
                    <input type="" class="lat_position" value="{{ $position->lat }}">
                    <input type="" class="lng_position" value="{{ $position->lng }}">
                    <input type="" class="marker_description" value="{{ $position->description }}">
                </div>
            @endforeach
        </div>
    </div>
    <script>
        R.trip = JSON.parse(`{!! $trip !!}`);
    </script>
@endsection
@section('head')
    <script src="{{ url('js/trip/index.js')  }}"></script>
@endsection

@section('map')
{{--    @include('user.include.map')--}}
@endsection
