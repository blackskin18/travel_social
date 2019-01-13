	<style>
		#header {
			background-image: url({{ url('asset/images/cover/'.$user->id.'/'.$user->cover) }}), url(../../images/bg.jpg);
		}
	</style>

	<header id="header">
		<div>
			<div style="display: inline-block; position: absolute; top: 0; left: 2.5em;">
				<button class="button small">
					Thêm bạn
				</button>
				<button class="button small">
					theo dõi
				</button>
				<button  class="button small margin-top-1">
					nhắn tin
				</button>
			</div>
		</div>
		<div class="inner avatar_display">
            @include('user.include.upload_avatar')
            <a href="{{route('personal.page', ['id' => $user->id])}}">
                <h1><strong>{{ $user->name  }}</strong></h1>
            </a>
		</div>
		<div class="more-info">
			<div class="album">
				album
			</div>
			<a href="{{ route('detail.info', $user->id) }}">
				<div class="detail-info">
					Thông tin
				</div>
			</a>
			<div class="list-friend">
				Bạn bè
			</div>
		</div>
	</header>
