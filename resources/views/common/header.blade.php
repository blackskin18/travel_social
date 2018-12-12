<!DOCTYPE HTML>
<html>
<head>
    <title>Mạng Xã Hội Du lịch</title>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link id="bootstrap-styleshhet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css'
          integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
    <link rel="stylesheet" href="{{ url('css/main.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/common.css') }}"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ url('js/common.js') }}"></script>
    <script src="{{ url('js/map.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlkPRpU8Qk221zsdBOpn8cVl_WDSBtIWk&callback=initMap"
        async defer></script>
    @yield('head')

</head>
<body class="is-preload">
@yield('map')
@include('include.display_image_popup')

<nav class="menu-header">
    <div class="logo image">
        <img src="{{ url('asset/icon/logo.png') }}" alt="">
    </div>
    <div class="search-box">
        <input class="search" type="text">
    </div>
    <div class="notifycation">
        <a href="{{ route('personal.page', Auth::user()->id) }}">
            <div class="info">
                <div class="image-nav avatar">
                    @if(Auth::user()->avatar)
                        <img class="avatar-nav"
                             src="{{ url('asset/images/avatar/'.Auth::user()->id.'/'.Auth::user()->avatar) }}" alt="">
                    @else
                        <img class="avatar-nav" src="{{ url('asset/images/avatar/default/avatar_default.png') }}" alt=""/>
                    @endif
                </div>
                <div class="username-nav">
                    {{ Auth::user()->name }}
                </div>
            </div>
        </a>
        <div class="add-friend">
			<span>
				<img class="icon" src="{{ url('asset/icon/logo.png') }}" alt="">
			</span>
        </div>
        <div class="messenger">
			<span>
				<img class="icon" src="{{ url('asset/icon/logo.png') }}" alt="">
			</span>
        </div>
        <div class="article-notify">
			<span>
				<img class="icon" src="{{ url('asset/icon/logo.png') }}" alt="">
			</span>
        </div>
    </div>
</nav>
