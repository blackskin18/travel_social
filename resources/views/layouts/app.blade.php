<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css'
          integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
    <link rel="stylesheet" href="{{ url('css/main.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/common.css') }}"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.8.5/firebase.js"></script>
    <script src="{{asset('js/common.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="menu-header">
    <div class="row w-100">
        <div class="col-lg-1 display_inline_block">
            <a href="{{route('home')}}">
                <div class="logo image">
                    <i class='notification_icon fas fa-home' style='font-size:36px'></i>
                </div>
            </a>
        </div>
        <div class="col-lg-8 display_inline_block">
        </div>
        <div class="col-lg-2 display_inline_block">
            <div class="row">
                <a href="" class="col-lg-6 text-white text-center"> Đăng nhập</a>
                <a href="" class="col-lg-6 text-white text-center"> Đăng ký</a>
            </div>
        </div>
    </div>

</nav>
@yield('content')
</body>
</html>
