$(function () {
    $(".btn_show_map").click(function () {
        let myMap = new MapCustom();
        let articleId = $(this).data('post-id');
        myMap.initMap();
        myMap.addListenerShowMap("div#article_info_position_" + articleId);
        $("div.map_box").css("display", "block");
    });

    $(".btn_post_setting").click(function () {
        var tripId = $(this).data('trip-id');
        var url = $(this).data('action');
        var method = $(this).data('method') ? $(this).data('method') : "post";
        console.log( $(this).data('method'));
        var element = $(this);
        $.ajax({
            url: url,
            type: 'post',
            data: {trip_id: tripId, _method: method},
            success: function (firebaseResponse) {
                console.log(firebaseResponse);
                let data = JSON.parse(firebaseResponse);
                if(data.type === 'create_join_request') {
                    element.css('display','none');
                    $("#decline_join_request_"+tripId).css('display', 'block');
                } else if (data.type === 'decline_join_request' || data.type === 'decline_invitation' || data.type === 'leave_the_trip') {
                    element.css('display','none');
                    $("#accept_invitation_"+tripId).css('display', 'none');
                    $("#show_trip_"+tripId).css('display', 'none');
                    $("#create_join_request_"+tripId).css('display', 'block');
                } else if (data.type === 'accept_invitation') {
                    element.css('display','none');
                    $("#decline_invitation_"+tripId).css('display', 'none');
                    $("#show_trip_"+tripId).css('display', 'block');
                    $("#leave_trip_request_"+tripId).css('display', 'block');
                }
            },
            error: function () {
                alert('something error');
            }
        });
    });
    
    $("div.btn_comment").click(function () {
        var postId = $(this).data('article-id');
        $("div#comment_box_" + postId).css("display", "block");
        $("div#comment_box_" + postId + ">.list_comment").html("");
        var Ref = R.firebaseDB.ref('comments/posts/' + postId);
        var avatarSrc;
        Ref.on('child_added', function (firebaseResponse) {
            var comment = firebaseResponse.val();
            avatarSrc = comment.avatar ? `${window.location.origin}/asset/images/avatar/${comment.user_id}/${comment.avatar}` : `${window.location.origin}/asset/images/avatar/default/avatar_default.png`;
            var commentElement = `
                    <div class="row" id="comment_box_${firebaseResponse.key}">
                        <div class="avatar_comment_box col-lg-1">
                            <img class="avatar_image" src="${avatarSrc}" alt="">
                        </div>
                        <div class="comment" id="comment_content_${firebaseResponse.key}">
                            <div class="comment_content display_block">
                                <a href="/user/personal-page/${comment.user_id}">
                                    ${comment.user_name}
                                </a>
                                <div class="display_inline_block content_text" >
                                    ${comment.content}
                                </div>
                            </div>
                            <input type="text" class="edit_comment_input display_none_important" id="edit_comment_input_${firebaseResponse.key}" value="${comment.content}" data-comment-id="${firebaseResponse.key}" data-post-id="${postId}">
                        </div>
                        <div class="display_inline_block comment_options">
                            <div class="dropdown">
                                <a class="" data-toggle="dropdown">
                                    <i class="material-icons">settings_ethernet</i>
                                </a>
                                <div class="dropdown-menu">
                                     <a class="dropdown-item" id="edit_comment_${firebaseResponse.key}" data-comment-id="${firebaseResponse.key}"> Sửa </a>
                                     <a class="dropdown-item" id="remove_comment_${firebaseResponse.key}" data-comment-id="${firebaseResponse.key}"> Xóa </a>
                                </div>
                            </div>
                        </div>
                    </div>`;
            $("div#comment_box_" + postId + ">.list_comment").prepend(commentElement);

            $("#remove_comment_" + firebaseResponse.key).click(function () {
                $.ajax({
                    url: '/comment/post/remove',
                    type: 'get',
                    data: {post_id: postId, comment_id: firebaseResponse.key},
                    success: function (response) {
                        console.log("remove successful")
                    },
                    error: function () {
                        alert('something error');
                    }
                });
            });

            $("#edit_comment_" + firebaseResponse.key).click(function () {
                $("div#comment_content_"+firebaseResponse.key+ " .comment_content").addClass('display_none_important').removeClass("display_block");
                $("div#comment_content_"+firebaseResponse.key+ " .edit_comment_input").addClass('display_block').removeClass("display_none_important").focus();
            });

            $("#edit_comment_input_" + firebaseResponse.key).on('keyup', function(event) {
                if (event.key === "Escape") {
                    $("div#comment_content_"+firebaseResponse.key+ " .comment_content").addClass('display_block').removeClass("display_none_important");
                    $("div#comment_content_"+firebaseResponse.key+ " .edit_comment_input").addClass('display_none_important').removeClass("display_block");
                } else if(event.key === "Enter") {
                    var newComment = $(this).val();
                    $.ajax({
                        url: '/comment/post/edit',
                        type: 'get',
                        data: {post_id: postId, comment_id: firebaseResponse.key, message: $(this).val()},
                        success: function (response) {
                            $("div#comment_content_"+firebaseResponse.key+ " .comment_content").addClass('display_block').removeClass("display_none_important");
                            $("div#comment_content_"+firebaseResponse.key+ " .comment_content .content_text").html(newComment);
                            $("div#comment_content_"+firebaseResponse.key+ " .edit_comment_input").addClass('display_none_important').removeClass("display_block").val(newComment);
                        },
                        error: function () {
                            alert('something error');
                        }
                    });
                }
            });
        });
        Ref.on('child_changed', function (firebaseResponse) {
            $("div#comment_content_"+firebaseResponse.key+ " .comment_content .content_text").html(firebaseResponse.val().content);
        });

        Ref.on('child_removed', function (firebaseResponse) {
            $("div#comment_box_"+firebaseResponse.key).remove();
        });
    });

    $("input.comment_input").keypress(function (event) {
        if (event.which === 13) {
            var postId  = $(this).data('article-id');
            var message = $(this).val();
            var commentInput = $(this);
            $.ajax({
                url: '/comment/post',
                type: 'get',
                data: {post_id: postId , message: message},
                success: function (response) {
                    commentInput.val('');
                    console.log("comment successful");
                },
                error: function () {
                    alert('something error');
                }
            });
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
