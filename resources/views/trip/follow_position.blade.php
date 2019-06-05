@extends('common.master')

@section('content')
    <input type="hidden" id="firebase_token" value="{{$firebase_token}}">
    <div class="content_container">
        <div class="text-center">
            <a href="{{Route('trip.show', ['id' => $trip->id])}}">
                <h1>
                    {{$trip->title}}
                </h1>
            </a>

        </div>
        <div style="position: relative">
            <div id="map_search_position_panel">
                <input id="address" type="textbox" value="">
                <button id="map_search_position" class="btn  btn-info btn-sm"> Tìm kiếm </button>
            </div>
            <div id="map" style="width: 100%; height: 500px;">
        </div>

        </div>
        <div class="hidden_input" id="position_info">
            @include('utils.position_info', ['post' => $trip] )
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
