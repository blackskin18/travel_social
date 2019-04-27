<form action="{{ route('post.create')  }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="hidden_input" id="hidden_input">
        <div id="marker_info_box">
        </div>
    </div>
    <div style="margin-bottom: 20px">
        <textarea class="input-border" id="post_description" name="post_description" cols="30"
                  rows="3"></textarea>
        <div id="create_trip_box" style="display: none">
            <input type="checkbox" name="is_create_trip" id="check_create_trip" value="1">
            <div class="form-group">
                <label for="email">Tên chuyến đi:</label>
                <input type="text" name="trip_title" class="form-control" id="title">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian đi: </label>
                <input type="date" name="time_start" class="form-control" id="pwd">
            </div>
            <div class="form-group">
                <label for="pwd"> Thời gian về: </label>
                <input type="date" name="time_end" class="form-control" id="pwd">
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
        <ul class="actions" style="margin-bottom: 0px; height: 50px">
            <li><a href="#" class="button" id="btn_create_map">Map</a></li>
            <li>
                <div class="upload-btn-wrapper">
                    <button class="button">Upload a file</button>
                    <input type="file" name="photos[]" multiple accept="image/x-png,image/jpeg"/>
                </div>
            </li>
            <li><a href="#" class="button" id="btn_create_trip">Thêm chức năng Đi chung</a></li>
        </ul>
    </div>
    <input type="submit" class="button primary" value="Đăng">
</form>
<script src="{{ url('js/include/create_post.js') }}"></script>

