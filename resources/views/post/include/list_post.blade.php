@foreach($posts as $post)
    @include('post.include.post', ["post" => $post])
@endforeach

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>--}}
<script src="{{ url('js/User/Include/post.js') }}"></script>
