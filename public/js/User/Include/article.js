$(function () {
    $(".post_setting_btn").click(function () {
        var postId = $(this).data('post-id')
        var popupSettingHtml = `<div class="popup_setting" style="width: 100%"><ul>
                                <li><a href="">edit</a></li>
                                <li><a href="${window.location.origin}/post/delete/${postId}">delete</a></li>
                            </ul></div>`;
        $(this).popModal({
            html: popupSettingHtml,
            placement: 'rightTop',
            showCloseBut: true,
            onOkBut: function () {
            },
            onCancelBut: function () {
            },
            onLoad: function () {
            },
            onClose: function () {
            }
        });
    });


    $("div.btn_comment").click(function () {
        var articleId = $(this).data('article-id');
        $("div#comment_box_" + articleId).css("display", "block");
        $("div#comment_box_" + articleId + ">.list_comment").html("");

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });

        $.ajax({
            url: '/comment/get',
            type: 'GET',
            data: {post_id: articleId},
            success: function (response) {
                var data = response.data;
                for (var i in data) {
                    if (data[i].user.avatar) {
                        var avatar = src = window.location.origin + '/asset/images/avatar/' + data[i].user.id + '/' + data[i].user.avatar;
                    } else {
                        var avatar = window.location.origin + '/asset/images/avatar/default/avatar_default.png';
                    }
                    var commentElement = `
                        <div class="row">
                            <div class="avatar_comment_box col-lg-1">
                                <img class="avatar_image" src="${avatar}" alt="">
                            </div>
                                <div class="comment">
                                    <a href="/user/personal-page/${data[i].user_id}">
                                        ${data[i].user.name}
                                    </a>
                                    <div style="display: inline-block;">
                                        <p>${data[i].content}</p>
                                    </div>
                                </div>
                        </div>`;
                    $("div#comment_box_" + articleId + ">.list_comment").append(commentElement);
                }
            }
        });

    });

    $("input.comment_input").keypress(function (event) {
        if (event.which === 13) {
            var articleId = $(this).data('article-id');
            var message = $(this).val();
            $(this).val("");

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });

            $.ajax({
                url: '/comment/send',
                type: 'POST',
                data: {comment_content: message, post_id: articleId},
                success: function (data) {
                    // console.log(data);
                }
            });
        }
    });
});

$(document).ready(function () {
    var socket = io.connect('http://127.0.0.1:8890');
    console.log('connected..');
    socket.on('message', function (data) {
        data = $.parseJSON(data);
        var commentElement = `
                        <div class="row">
                            <div class="avatar_comment_box col-lg-1">
                                <img class="avatar_image" src="${window.location.origin}/asset/images/avatar/${data.user_id}/${data.user_avatar}" alt="">
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
        $("div#comment_box_" + data.post_id + ">.list_comment").prepend(commentElement);
    });
});
