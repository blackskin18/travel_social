$(function () {
    $(".btn_show_map").click(function () {
        let myMap = new MapCustom();
        let articleId = $(this).data('post-id');
        myMap.initMap();
        myMap.addListenerShowMap("div#article_info_position_" + articleId);
        $("div.map_box").css("display", "block");
    });

    $(".post_setting_btn").click(function () {
        var postId = $(this).data('post-id');
        var authUser = $(this).data('auth-user');
        var postOwner = $(this).data('post-owner');
        var tripId = $(this).data('trip-id');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var settingElement = $(this);

        var popupSettingHtml = `<div class="popup_setting" style="width: 100%"><ul>`;
        if (authUser !== postOwner && tripId) {
            let joinRequestAccepted = $(this).data('join-request-accepted');
            if (joinRequestAccepted === 0) {
                popupSettingHtml += `<li id="join_btn"><form id="join_trip_${tripId}" method="post" action="/join-request/trip/create">
                                        <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                                        <input type="hidden" name="trip_id" value="${tripId}">
<!--                                        <a onclick="document.getElementById('join_trip_${tripId}').submit();">Hủy</a>-->
                                        <a class="button_join" data-trip-id="${tripId}">Hủy yêu cầu</a>
                                    </form></li>`
            } else if (joinRequestAccepted === 1) {
                popupSettingHtml += `<li id="join_btn"><form id="join_trip_${tripId}" method="post" action="/join-request/trip/create">
                                        <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                                        <input type="hidden" name="trip_id" value="${tripId}">
<!--                                        <a onclick="document.getElementById('join_trip_${tripId}').submit();">Xóa</a>-->
                                        <a class="button_join" data-trip-id="${tripId}"> 
                                            <p> Rời khỏi </p>
                                            <p>(bạn đang ở trong chuyến đi này)</p>
                                        </a>
                                    </form></li>`
            } else {
                popupSettingHtml += `<li id="join_btn"><form id="join_trip_${tripId}" method="post" action="/join-request/trip/create">
                                        <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                                        <input type="hidden" name="trip_id" value="${tripId}">
<!--                                        <a onclick="document.getElementById('join_trip_${tripId}').submit();">Tham Gia</a>-->
                                        <a class="button_join" data-trip-id="${tripId}">Xin tham Gia</a>
                                    </form></li>`
            }
        } else if (tripId) {
            popupSettingHtml += `<li id="join_btn"><a href="/trip/detail_info/${tripId}">Xem chuyến đi</a></li>`
        }

        if (authUser === postOwner) {
            popupSettingHtml += `<li><a href="/post/edit/${postId}"> Sửa bài viết </a></li>
                                <li>
                                    <form id="delete_post_${postId}" method="post" action="/post/delete/${postId}">
                                        <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                                        <input type="hidden" name="_method" value="DELETE">
                                        <a onclick="document.getElementById('delete_post_${postId}').submit();">Xóa bài viết</a>
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
                $(".button_join").click(function () {
                    var tripId = $(this).data('trip-id');
                    var element = $(this);
                        $.ajax({
                            url: '/trip/join-request/create_or_delete',
                            type: 'post',
                            data: {trip_id: tripId},
                            success: function (response) {
                                if(response.type === "delete_request") {
                                    settingElement.data('join-request-accepted', null);
                                    element.text("Xin tham gia");
                                } else {
                                    settingElement.data('join-request-accepted', 0);
                                    element.text("Hủy yêu cầu");
                                }
                            },
                            error: function () {
                                alert('something error');
                            }
                        });
                });
            },
            onClose: function () {
            }
        });
    });

    $("div.btn_comment").click(function () {
        var postId = $(this).data('article-id');
        $("div#comment_box_" + postId).css("display", "block");
        $("div#comment_box_" + postId + ">.list_comment").html("");
        var Ref = R.firebaseDB.ref('posts/' + postId + '/comments');
        var avatarSrc;
        Ref.on('child_added', function (response) {
            var comment = response.val();
            avatarSrc = comment.avatar ? `${window.location.origin}/asset/images/avatar/${comment.user_id}/${comment.avatar}` : `${window.location.origin}/asset/images/avatar/default/avatar_default.png`;
            var commentElement = `
                    <div class="row">
                        <div class="avatar_comment_box col-lg-1">
                            <img class="avatar_image" src="${avatarSrc}" alt="">
                        </div>
                            <div class="comment">
                                <a href="/user/personal-page/${comment.user_id}">
                                    ${comment.user_name}
                                </a>
                                <div style="display: inline-block;">
                                    <p>${comment.content}</p>
                                </div>
                            </div>
                    </div>`;
            console.log(commentElement);
            $("div#comment_box_" + postId + ">.list_comment").prepend(commentElement);
        });
    });

    $("input.comment_input").keypress(function (event) {
        if (event.which === 13) {
            var articleId = $(this).data('article-id');
            var message = $(this).val();
            var newPostKey = R.firebaseDB.ref().child('posts/' + articleId + '/comments').push().key;
            var updates = {};
            updates['posts/' + articleId + '/comments/' + newPostKey] = {
                'avatar': R.userAvatar,
                'user_id': R.userId,
                'content': message,
                'user_name': R.userName
            };
            R.firebaseDB.ref().update(updates)
        }
    });

    $("div.btn_like").click(function () {
        var postId = $(this).data('post-id');
        var btnElement = $(this);
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

                $("#count_like_in_" + postId).html(data.count_like + " lượt thích");
            },
            error: function () {
                alert('something error');
            }
        });
    })
});
