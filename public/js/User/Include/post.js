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
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
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
            $("div#comment_box_" + postId + ">.list_comment").prepend(commentElement);
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
