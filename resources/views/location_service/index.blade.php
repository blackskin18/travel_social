@extends('common.master')

@section('content')
    <div id="map" style="margin-top: 50px; width: 1000px; height: 600px"></div>
@endsection
@section('head')
    <script src="{{ url('js/location_service/index.js')  }}"></script>
@endsection
