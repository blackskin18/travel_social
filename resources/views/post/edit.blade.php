@extends('common.master')

@section('content')
    <div id="main" style="margin: auto">
        <section id="one">
            <header class="major">
                <h2> Sửa bài viết </h2>
            </header>
            <form action="{{ route('post.update', ['id'=>$post->id])  }}" method="POST" id="edit_post"
                  enctype="multipart/form-data">
                @csrf
                <div>
                    <div id="marker_info_box">
                        @foreach($post->position as $key => $position)
                            <div class="marker_info">
                                <input type="hidden" name="lat[]" class="lat_position" value="{{$position->lat}}">
                                <input type="hidden" name="lng[]" class="lng_position" value="{{$position->lng}}">
                                <input type="hidden" name="marker_description[]" class="marker_description"
                                       value="{{$position->description}}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div style="margin-bottom: 20px">
                    <textarea class="input-border" id="post_description" name="post_description" cols="30"
                              rows="3">{{$post->description}}</textarea>
                    <ul class="actions" style="margin-bottom: 0px; height: 50px">
                        <li><a href="#" class="button" id="btn_create_map">Map</a></li>
                        <li>
                            <div class="upload-btn-wrapper">
                                <button class="button">Upload a file</button>
                                <input type="file" name="photos[]" id="image_input" multiple accept="image/x-png,image/jpeg"/>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="row image_list" id="image_list_{{$post->id}}">
                    @foreach($post->post_image as $key => $image)
                        <div class="col-6 col-12-xsmall work-item image_in_post" id="image_{{$image->id}}">
                            <a class="image fit image_showed" data-post-id="{{$post->id}}" data-index="{{$key}}">
                                <img src="{{ url('/storage/post/'.$image->post_id.'/'.$image->image) }}" alt=""/>
                            </a>
                            <a class="btn_delete" data-image-id="{{$image->id}}" data-post-id="{{$post->id}}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                <input type="submit" class="button primary" value="Đăng">
            </form>
        </section>
    </div>
    <script src="{{ url('js/include/create_post.js') }}"></script>
@endsection
@section('head')
    <script src="{{url('js/post/edit.js')}}"></script>
@endsection
@section('map')
    @include('user.include.map')
@endsection
