@if($user->id == Auth::user()->id)
	<td class="">
		<button class="button small primary fit edit_info_btn" id="{{ $id }}" >Sửa</button>
	</td>
@endif
