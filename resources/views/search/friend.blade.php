@extends('common.master')


@section('content')
    <div id="main" style="margin: auto">
        <h1 class="text-center">
            Kết quả tìm kiếm người dùng
        </h1>
        @foreach($users as $user)
            <div class="row">
                <div class="col-lg-8 offset-lg-2 position-relative">
                    <div>
                        <div class="media border p-3">
                            <img src=" {{ $user->avatar ? url('asset/images/avatar/'.$user->id.'/'.$user->avatar) : url('asset/images/avatar/default/avatar_default.png') }}"
                                 alt="John Doe" class="ml-5 mr-3 mt-3 rounded-circle" style="width:60px;">
                            <div class="media-body">
                                <h4 class="pt-4 pl-3"> {{$user->name}} </h4>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute" style="top: 40px; right: 50px">
                        <button class="btn btn-info"> kết bạn </button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection
