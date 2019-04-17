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
                @foreach($invitations as $invitation)
                    @if($invitation->user_id !== $trip->user_id)
                        <tr>
                            <td>
                                <a href="{{route('personal.page', ['id' => $invitation->user->id])}}">
                                    {{ $invitation->user->name }}
                                </a>
                            </td>
                            <td>{{ $invitation->user->email }}</td>
                            <td>
                                @if($invitation->user_id === Auth::user()->id)
                                    @if($invitation->accepted)
                                        Sẽ tham gia
                                        <form action="{{ route('invitation.accept')  }}" class="none-margin" method="post">
                                            @csrf
                                            <input type="hidden" name="trip_id" value="{{$invitation->trip_id}}">
                                            <input type="submit" class="button small" value="Hủy">
                                        </form>
                                    @else
                                        <form action="{{ route('invitation.accept')  }}" class="none-margin" method="post">
                                            @csrf
                                            <input type="hidden" name="trip_id" value="{{$invitation->trip_id}}">
                                            <input type="submit" class="button small" value="Tham gia">
                                        </form>
                                    @endif
                                @else
                                    @if($invitation->accepted)
                                        Sẽ tham gia
                                    @else
                                        Đang đợi xác nhận
                                    @endif
                                @endif
                            </td>
                            @if($trip->user_id === Auth::user()->id && $invitation->user_id !== Auth::user()->id)
                                <td><button>xóa</button></td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
