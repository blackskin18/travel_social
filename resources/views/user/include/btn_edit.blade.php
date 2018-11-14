@if($user->id == Auth::user()->id)
	<td class="">
		<button class="button primary fit">Sửa</button>
	</td>
@endif