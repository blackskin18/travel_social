<div class="left-menu">
    <ul>
        <li><a href="{{ route('user.personal_page', Auth::user()->id) }}">Trang cá nhân</a></li>
        <li><a href="{{ route('trip.create')}}"> Tạo chuyến đi </a></li>
        <li><a href="{{ route('trip.list')}}"> Danh sách các chuyến đi</a>  </li>
        <li><a href="{{ route('home') }}">Bảng tin</a> </li>
    </ul>
</div>
