<link rel="stylesheet" href="{{ url('lib/cropper/css/cropper.css') }}">
<div class="avatar">
    <img src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}" alt=""/>
    @if($user->id == Auth::user()->id)
        <a class="change_avatar" id="change_avatar">
            Thay Ảnh
            <input type="file" class="" id="input_change_avatar" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
        </a>
    @endif
</div>
@if($user->id == Auth::user()->id)
    <div class="popup change_avatar_box" id="change_avatar_box">
        <div class="popup_opacity">
        </div>
        <div class="popup_content" style="z-index: 102">
            <div id="crop_box">
                <div style="width: 500px; height: 500px">
                    <img src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}" alt="" id="image1"
                         style="max-width: 100%">
                </div>
            </div>
            <div class="">
                <button class="button" id="submit_change_avatar"> Thay đổi</button>
            </div>
            <div class=" popup_close">
            </div>
        </div>
    </div>
    <script src="{{ url('lib/cropper/js/cropper.js') }}"></script>
    <script src="{{ url('js/User/Include/upload_avatar.js')  }}"></script>
@endif
