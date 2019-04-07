@extends('common.master')

@section('content')
	@include('user.include.left_menu')
	<!-- Main -->`
	<div id="main">
		<div class="table-wrapper">
			<table class="alt">
				<tbody>
					<tr>
						<td class="" style="width:20%">Tên</td>
						<td class="user_info">{{ $user->name }}</td>
						@include('user.include.btn_edit', ['id' => 'edit_name'])
					</tr>
                    <tr>
                        <td class="" style="width:20%">Tên phụ</td>
                        <td class="user_info">{{ $user->nick_name }}</td>
                        @include('user.include.btn_edit', ['id' => 'edit_nick_name'])
                    </tr>
					<tr>
						<td >Số điện thoại</td>
						<td>{{ $user->phone }}</td>
						@include('user.include.btn_edit', ['id' => 'edit_phone'])
					</tr>
                    <tr>
                        <td >Giới tính</td>
                        <td>{{ $user->gender }}</td>
                        @include('user.include.btn_edit', ['id' => 'edit_gender'])
                    </tr>
					<tr>
						<td>Địa chỉ</td>
						<td>{{ $user->address }}</td>
						@include('user.include.btn_edit',['id' => 'edit_address'])
					</tr>
					<tr>
						<td>Email</td>
						<td>{{ $user->email }}</td>
						@include('user.include.btn_edit', ['id' => 'edit_email'])
					</tr>
					<tr>
						<td>Giới Thiệu</td>
						<td>{{ $user->description }}</td>
						@include('user.include.btn_edit', ['id' => 'edit_description'])
					</tr>
				</tbody>
			</table>
		</div>
	</div>
    <script src="{{ url('js/User/detail_info.js')  }}"></script>
@endsection
