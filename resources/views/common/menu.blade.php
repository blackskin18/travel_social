<div class="left-menu">
    <ul>
        <li><a href="{{ route('personal.page', Auth::user()->id) }}">Trang cá nhân</a></li>
        <li><a href="{{ route('trip.create')}}">create Trip </a></li>
        <li><a href="{{ route('trip.list')}}"> danh sách các chuyến đi</a>  </li>
        <li><a href="">lời mời than gia chuyến đi</a>  </li>
        <li><a href="{{ route('home') }}">Bảng tin</a> </li>
    </ul>
</div>
