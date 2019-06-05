<form action="{{ route('post.create')  }}" method="POST" enctype="multipart/form-data" id="form_create_post">
    @csrf
    <div class="hidden_input" id="hidden_input">
        <div id="marker_info_box">
        </div>
    </div>
    <div style="margin-bottom: 20px">
        <textarea class="input-border" id="post_description" name="post_description" cols="30"
                  rows="3"></textarea>
        <div id="create_trip_box" style="display: none">
            <input type="checkbox" class="hidden_input" name="is_create_trip" id="check_create_trip" value="1">
            <div class="form-group">
                <label for="email">Tên chuyến đi:</label>
                <input type="text" name="trip_title" class="form-control" id="trip_title_input">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian đi: </label>
                <input type="date" name="time_start" class="form-control" id="time_start_input">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian về: </label>
                <input type="date" name="time_end" class="form-control" id="time_end_input">
            </div>
            <div class="form-group">
                <label for="member"> Thành viên: </label>
                <select multiple class="selectpicker" data-show-subtext="true"
                        data-live-search="true" name="member[]">
                    @foreach($allUser as $member)
                        <option data-subtext="{{$member->email}}"
                                value="{{$member->id}}">{{$member->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <ul class="actions row" style="margin-bottom: 0px; height: 50px">
            <li class="col-lg-4"><a href="#" class="button w-100" id="btn_create_map">Tạo lịch trình</a></li>
            <li class="col-lg-4 pl-0">
                <div class="upload-btn-wrapper w-100">
                    <button class="button w-100">Thêm ảnh</button>
                    <input type="file" name="photos[]" multiple accept="image/x-png,image/jpeg"/>
                </div>
            </li>
            <li class="col-lg-4 pl-0"><a href="#" class="button w-100" id="btn_create_trip">Tìm người đi chung</a></li>
        </ul>
    </div>
</form>
<button class="button primary" id="btn_create_post"> Tạo bài viêt </button>
<script src="{{ url('js/include/create_post.js') }}"></script>

