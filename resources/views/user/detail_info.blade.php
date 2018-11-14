@extends('common.master')

@section('content')
	@include('user.include.left_menu')
	<!-- Main -->`
	<div id="main">
		<div class="table-wrapper">
			<table class="alt">
				<tbody>
					<tr>
						<td class="" style="width:20%">tên</td>
						<td class="">{{ $user->name }}</td>
						@include('user.include.btn_edit')
					</tr>
					<tr>
						<td >số điện thoại</td>
						<td>{{ $user->phone }}</td>
						@include('user.include.btn_edit')
					</tr>
					<tr>
						<td>Địa chỉ</td>
						<td>{{ $user->address }}</td>
						@include('user.include.btn_edit')
					</tr>
					<tr>
						<td>Email</td>
						<td>{{ $user->email }}</td>
						@include('user.include.btn_edit')
					</tr>
					<tr>
						<td>Giới Thiệu</td>
						<td>{{ $user->description }}</td>
						@include('user.include.btn_edit')
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection
