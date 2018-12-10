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
            {{--<div class="image avatar">--}}
                {{--<img src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}" alt=""/>--}}
                {{--<a class="change_avatar" id="change_avatar">--}}
                    {{--Thay Ảnh--}}
                    {{--<input type="file" class="" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">--}}
                {{--</a>--}}
            {{--</div>--}}
            @include('user.include.upload_avatar')

            <h1><strong>I am {{ $user->name  }}</strong></h1>
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
