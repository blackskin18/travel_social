<!DOCTYPE HTML>
<html>
<head>
    <title>Mạng Xã Hội Du lịch</title>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link id="bootstrap-styleshhet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css'
          integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
    <link rel="stylesheet" href="{{url('lib/pop_modal/css/popModal.css')}}">

    <link rel="stylesheet" href="{{ url('css/main.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/common.css') }}"/>


{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{url('lib/pop_modal/js/popModal.js')}}"></script>
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
    <a href="{{route('home')}}">
        <div class="logo image">
            <img src="{{ url('asset/icon/logo.png') }}" alt="">
        </div>
    </a>

    <div class="search-box">
        <input class="search" type="text">
    </div>
    <div class="notifycation">
        <div class="avatar_nav_box">
            <a href="{{ route('personal.page', Auth::user()->id) }}">
                <div class="info">
                    <div class="image-nav avatar">
                        @if(Auth::user()->avatar)
                            <img class="avatar-nav"
                                 src="{{ url('asset/images/avatar/'.Auth::user()->id.'/'.Auth::user()->avatar) }}"
                                 alt="">
                        @else
                            <img class="avatar-nav" src="{{ url('asset/images/avatar/default/avatar_default.png') }}"
                                 alt=""/>
                        @endif
                    </div>
                    <div class="username-nav">
                        {{ Auth::user()->name }}
                    </div>
                </div>
            </a>
        </div>

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
        <div class="setting_nav display_inline_block">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{--<span class="caret"></span>--}}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
