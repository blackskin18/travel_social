<!DOCTYPE HTML>
<html>
<head>
    <title>Mạng Xã Hội Du lịch</title>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="user-name" content="{{ auth::user()->name }}"/>
    <meta name="user-id" content="{{ auth::user()->id }}"/>
    <meta name="user-avatar" content="{{ auth::user()->avatar }}"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{url('lib/bootstrap.min.css')}}">
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>--}}
    <script src="{{url('lib/popper.min.js')}}"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css'
          integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">--}}
    <link rel="stylesheet" href="{{url('lib/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{url('lib/pop_modal/css/popModal.css')}}">
    <link rel="stylesheet" href="{{ url('css/main.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/common.css') }}"/>

{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
{{--    <script src="https://www.gstatic.com/firebasejs/5.8.5/firebase.js"></script>--}}
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>--}}
    <script src="{{url('lib/jquery.min.js')}}"></script>
    <script src="{{url('lib/firebase.js')}}"></script>
    <script src="{{url('lib/bootstrap.min.js')}}"></script>
    <script src="{{url('lib/bootstrap-select.min.js')}}"></script>

    <script src="{{url('lib/pop_modal/js/popModal.js')}}"></script>
    <script src="{{ url('js/common.js') }}"></script>
    <script src="{{ url('js/notification.js') }}"></script>
    <script src="{{ url('js/map.js') }}"></script>

    @yield('head')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlkPRpU8Qk221zsdBOpn8cVl_WDSBtIWk&callback=initMap"
        async defer></script>

</head>
<body class="is-preload">
@yield('map')
@include('include.display_image_popup')

<nav class="menu-header">
    <a href="{{route('home')}}">
        <div class="logo image">
            <i class='notification_icon fas fa-home' style='font-size:36px'></i>
        </div>
    </a>

    <div class="search-box">
        <input class="search" type="text" id="search_input">
        <div class="dropdown display_inline_block">
            <button class="btn btn-light dropdown-toggle" data-toggle="dropdown">search</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" id="btn_search_friend">Tìm bạn bè</a>
                <a class="dropdown-item" id="btn_search_post">Tìm bài viết</a>
            </div>
        </div>
    </div>
    <div class="notifycation">
        <div class="avatar_nav_box">
            <a href="{{ route('user.personal.page', Auth::user()->id) }}">
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

        <div class="add-friend" id="btn_show_friend_notify" data-size="{'width':'800'}">
            <div>
                <a class=" position-relative">
                    <div class="position-absolute">
                        <i class="notification_icon fas fa-user"></i>
                    </div>
                    <div class="count_friend_notify count_notify"></div>
                </a>
                <div class="display_none" id="friend_notification_box">
                    <div style="width: 450px">
                    </div>
                </div>
            </div>
        </div>

        <div class="messenger" id="btn_show_trip_member_notify">
            <div>
                <a class=" position-relative">
                    <div class="position-absolute">
                        <i class="notification_icon fas fa-car-alt"></i>
                    </div>
                    <div class="count_member_notify count_notify"></div>
                </a>
                <div class="display_none" id="member_notification_box">
                    <div style="width: 450px">
                    </div>
                </div>
            </div>
        </div>
        <div  class="article-notify" id="btn_show_other_notify" >
            <div>
                <a class=" position-relative">
                    <div class="position-absolute">
                        <i class="notification_icon material-icons">notifications</i>
                    </div>
                    <div class="count_other_notify count_notify"></div>
                </a>
                <div class="display_none" id="other_notification_box">
                    <div style="width: 450px">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="setting_nav display_inline_block">
        <div class="collapse navbar-collapse show" id="navbarSupportedContent">
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
                            <input type="header" name="device_token">
                            <script>
                                $(function () {
                                    R.firebaseMessaging.getToken().then(function(currentToken) {
                                        if (currentToken) {
                                            $('input[name="device_token"]').val(currentToken);
                                        }
                                    }).catch(function(err) {
                                        console.log('An error occurred while retrieving token. ', err);
                                    });
                                });
                            </script>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
