@foreach($posts as $post)
    @include('post.include.post', ["post" => $post])
@endforeach

<script src="{{ url('js/User/Include/post.js') }}"></script>
