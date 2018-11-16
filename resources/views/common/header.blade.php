
<!DOCTYPE HTML>
<html>
<head>
	<title>Mạng Xã Hội Du lịch</title>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link id="bootstrap-styleshhet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ url('css/main.css') }}" />
    <link rel="stylesheet" href="{{ url('css/common.css') }}" />
    <!-- Generic page styles -->
    <link rel="stylesheet" href="{{ url('lib/jquery-file-upload/css/style.css') }}">
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{ url('lib/jquery-file-upload/css/jquery.fileupload.css')  }}">
    <link rel="stylesheet" href="{{ url('lib/jquery-file-upload/css/jquery.fileupload-ui.css')  }}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    @yield('head')

</head>
<body class="is-preload">
@yield('map')
<nav class="menu-header">
	<div class="logo image">
		<img src="{{ url('asset/icon/logo.png') }}" alt="" >
	</div>
	<div class="search-box">
		<input class="search" type="text">
	</div>
	<div class="notifycation">
		<a href="{{ route('personal.page', Auth::user()->id) }}">
			<div class="info">
				<div class="image-nav">
					<img class="avatar-nav" src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}" alt="">
				</div>
				<div class="username-nav">
					{{ $user->name }}
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
