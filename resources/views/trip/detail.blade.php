@extends('common.master')
@section('content')
    <div class="content_container">
        <h1> {{ $trip->title }} </h1>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Ngày tạo</td>
                    <td>{{ $trip->created_at }}</td>
                </tr>
                <tr>
                    <td>Ngày bắt đầu</td>
                    <td>{{ $trip->time_start }}</td>
                </tr>
                <tr>
                    <td>Ngày kết thúc</td>
                    <td>{{ $trip->time_end }}</td>
                </tr>
                <tr>
                    <td>Người tạo</td>
                    <td><a href="{{ route('personal.page', Auth::user()->id) }}">
                            {{ $trip->user->name }}
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h1> Thành viên </h1>
        <table class="table table-striped">
            <tbody>
                @foreach($tripUsers as $tripUser)
                    @if($tripUser->user_id !== $trip->user_id)
                        <tr>
                            <td>
                                <a href="{{route('personal.page', ['id' => $tripUser->user->id])}}">
                                    {{ $tripUser->user->name }}
                                </a>
                            </td>
                            <td>{{ $tripUser->user->email }}</td>
                            <td>
                                @if($tripUser->user_id === Auth::user()->id)
                                    @if($tripUser->accepted)
                                        Sẽ tham gia
                                        <form action="{{route('trip.un_accept',['trip_id' => $trip->id])}}" class="none-margin" method="post">
                                            @csrf
                                            <input type="submit" class="button small" value="Hủy">
                                        </form>
                                    @else
                                        <form action="{{route('trip.accept',['trip_id' => $trip->id])}}" class="none-margin" method="post">
                                            @csrf
                                            <input type="submit" class="button small" value="Tham gia">
                                        </form>
                                    @endif

                                @else
                                    @if($tripUser->accepted)
                                        Sẽ tham gia
                                    @else
                                        Đang đợi xác nhận
                                    @endif
                                @endif
                            </td>
                            @if($trip->user_id === Auth::user()->id && $tripUser->user_id !== Auth::user()->id)
                                <td><button>xóa</button></td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
