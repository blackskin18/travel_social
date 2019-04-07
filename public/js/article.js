$(document).ready(function () {
    var socket = io.connect('http://127.0.0.1:8890');
    console.log('connected..');
    socket.on('message', function (data) {
        data = $.parseJSON(data);
        if(data.user_avatar) {
            var avatar = window.location.origin + '/asset/images/avatar/'+data.user_id+'/'+data.user_avatar;
        } else {
            var avatar = window.location.origin + '/asset/images/avatar/default/avatar_default.png';
        }
        var commentElement = `
                        <div class="row">
                            <div class="avatar_comment_box col-lg-1">
                                <img class="avatar_image" src="${avatar}" alt="">
                            </div>
                                <div class="comment">
                                    <a href="/user/personal-page/${data.user_id}">
                                        ${data.user_name}
                                    </a>
                                    <div style="display: inline-block;">
                                        <p>${data.comment}</p>
                                    </div>
                                </div>
                        </div>`;
        $("div#comment_box_" + data.post_id+">.list_comment").prepend(commentElement);
    });
});
