$(function () {
    $(".post_setting_btn").click(function () {
        var postId = $(this).data('post-id');
        var authUser = $(this).data('auth-user');
        var postOwner = $(this).data('post-owner');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var popupSettingHtml = `<div class="popup_setting" style="width: 100%"><ul>`;
        if(authUser !== postOwner) {
            popupSettingHtml += `<li id="join_btn"><a>Tham gia</a></li>`
        } else {
            popupSettingHtml += `<li><a href="/post/edit/${postId}"> Sửa bài viết </a></li>
                                <li>
                                    <form id="delete_post" method="post" action="/post/delete/${postId}">
                                        <input type="hidden" name="_token" value="${CSRF_TOKEN}" /> 
                                        <input type="hidden" name="_method" value="DELETE">
                                        <a onclick="document.getElementById('delete_post').submit();">Xóa bài viết</a>
                                    </form>
                                </li>`
        }
        popupSettingHtml += `</ul></div>`;

        $(this).popModal({
            html: popupSettingHtml,
            placement: 'rightTop',
            showCloseBut: true,
            onOkBut: function () {
            },
            onCancelBut: function () {
            },
            onLoad: function () {
                $("#join_btn").click(function () {
                    console.log("1")
                });
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
                        var avatar = window.location.origin + '/asset/images/avatar/' + data[i].user.id + '/' + data[i].user.avatar;
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

    $("div.btn_like").click(function () {
        var postId = $(this).data('post-id');
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var btnElement = $(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });

        $.ajax({
            url: '/like',
            type: 'post',
            data: {post_id: postId},
            success: function (response) {
                var data = JSON.parse(response).data;
                if (data.message === 'LIKE') {
                    btnElement.css('color', '#0ea27a');
                    btnElement.children().eq(0).css('color', '#0ea27a');
                } else {
                    btnElement.css('color', '#a2a2a2');
                    btnElement.children().eq(0).css('color', '#a2a2a2');
                }

                $("#count_like_in_"+postId).html(data.count_like + " lượt thích");
            },
            error: function () {
                alert('something error');
            }
        });

    })
});

$(document).ready(function () {
    var database = Firebase.getDatabase();
    var ref = database.ref('comments');
    ref.on("child_added", function(response) {
        var comment = response.val();
        var Ref = database.ref('users/' + comment.user_id);
        var avatarSrc;
        Ref.once('value', function (response) {
            var user = response.val();
            console.log(user);
            avatarSrc = user.avatar ? `${window.location.origin}/asset/images/avatar/${user.id}/${user.avatar}` : `${window.location.origin}/asset/images/avatar/default/avatar_default.png`;
            var commentElement = `
                        <div class="row">
                            <div class="avatar_comment_box col-lg-1">
                                <img class="avatar_image" src="${avatarSrc}" alt="">
                            </div>
                                <div class="comment">
                                    <a href="/user/personal-page/${comment.user_id}">
                                        ${user.name}
                                    </a>
                                    <div style="display: inline-block;">
                                        <p>${comment.content}</p>
                                    </div>
                                </div>
                        </div>`;
            $("div#comment_box_" + comment.post_id + ">.list_comment").prepend(commentElement);
        });
    });
});


// $(document).ready(function () {
//     var socket = io.connect('http://127.0.0.1:8890');
//     console.log('connected..');
//     socket.on('message', function (data) {
//         data = $.parseJSON(data);
//
//         $("#count_comment_in_" + data.post_id).text(data.count_comment + " bình luận");
//
//         var avtarSrc = data.user_avatar ? `${window.location.origin}/asset/images/avatar/${data.user_id}/${data.user_avatar}` : `${window.location.origin}/asset/images/avatar/default/avatar_default.png`;
//         var commentElement = `
//                         <div class="row">
//                             <div class="avatar_comment_box col-lg-1">
//                                 <img class="avatar_image" src="${avtarSrc}" alt="">
//                             </div>
//                                 <div class="comment">
//                                     <a href="/user/personal-page/${data.user_id}">
//                                         ${data.user_name}
//                                     </a>
//                                     <div style="display: inline-block;">
//                                         <p>${data.comment}</p>
//                                     </div>
//                                 </div>
//                         </div>`;
//         $("div#comment_box_" + data.post_id + ">.list_comment").prepend(commentElement);
//     });
// });
