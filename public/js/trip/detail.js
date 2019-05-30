window.onload = function () {
    $(".btn_show_map").click(function () {
        let myMap = new MapCustom();
        let articleId = $(this).data('trip-id');
        console.log(articleId);
        myMap.initMap();
        myMap.addListenerShowMap("div#trip_info_position_" + articleId);
        $("div.map_box").css("display", "block");
    });

    //add listener for button invite friends
    $("#btn_invite_friends").click(function () {

    });

    // add listener for button delete join request of other user
    $(".delete_member_invited").click(function () {
        let memberId = $(this).data('member-id');
        let tripId = $(this).data('trip-id');
        $.ajax({
            url: '/trip/invitation/reject_or_delete',
            type: 'post',
            data: {
                _method: "DELETE",
                member_id: memberId,
                trip_id: tripId
            },
            success: function (response) {
                $("tr#user_invited_"+memberId).remove();
            },
            error: function () {
                alert('something error');
            }
        });
    });

    // add listener for button accept join request of other user
    $(".btn_accept_join_request").click(function () {
        let tripId = $(this).data('trip-id');
        let friendId = $(this).data('friend-id');
        $.ajax({
            url: '/trip/join-request/accept',
            type: 'get',
            data: {
                friend_id: friendId,
                trip_id: tripId
            },
            success: function (response) {
                let data = JSON.parse(response);
                let memberData = data.member;
                console.log(data);
                $("tr#join_request_"+friendId).remove();
                let memberElement = `<tr id="member_${memberData.id}">
                                    <td class="p-1">
                                        <a href="/user/personal-page/${memberData.id}">
                                            <div class="media">
                                                <img
                                                    src="${memberData.avatar ? '/asset/images/avatar/'+memberData.id+'/'+memberData.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                                                    alt="{{$member->user->name}}" class="mr-3 rounded-circle"
                                                    style="width:60px;">
                                                <div class="media-body">
                                                    <h4 class="p-3"> ${memberData.name} </h4>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="p-1">
                                        <button class="btn btn-danger mb-4 btn_remove_member" data-member-id="${memberData.id}" data-trip-id="${tripId}"> Xóa</button>
                                    </td>
                                </tr>`;
                $("#table_list_member").append(memberElement);
                addListenerRemoveMember();
            },
            error: function () {
                alert('something error');
            }
        });
    });


    // add listener for button decline join request of other user
    $(".btn_reject_request_join").click(function () {
        let tripId = $(this).data('trip-id');
        let friendId = $(this).data('friend-id');
        $.ajax({
            url: '/trip/join-request/reject_or_cancel',
            type: 'post',
            data: {
                trip_id: tripId,
                friend_id: friendId,
                _method: "DELETE"
            },
            success: function (response) {
                $("tr#join_request_"+friendId).remove();
            },
            error: function () {
                alert('something error');
            }
        });
    });


    var addListenerRemoveMember = function() {
        // add listener for button remove member
        $(".btn_remove_member").click(function () {
            let memberId = $(this).data('member-id');
            let tripId = $(this).data('trip-id');
            $.ajax({
                url: '/trip/leave',
                type: 'post',
                data: {
                    member_id: memberId,
                    trip_id: tripId,
                    _method: "DELETE"
                },
                success: function (response) {
                    $("tr#member_"+memberId).remove();
                    // $("tr#user_invited_"+memberId).remove();
                },
                error: function () {
                    alert('something error');
                }
            });
        });
    };
    addListenerRemoveMember();


    // comment
    var tripId = $("#trip_id").val();
    console.log(tripId)
    $("div#comment_box_" + tripId).css("display", "block");
    $("div#comment_box_" + tripId + ">.list_comment").html("");
    var Ref = R.firebaseDB.ref('comments/trips/'+tripId);
    var avatarSrc;
    // onListener add comment
    Ref.on('child_added', function (firebaseResponse) {
        var comment = firebaseResponse.val();
        console.log(comment);
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
                            <input type="text" class="edit_comment_input display_none_important" id="edit_comment_input_${firebaseResponse.key}" value="${comment.content}" data-comment-id="${firebaseResponse.key}" data-post-id="${tripId}">
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
        $("div#comment_box_" + tripId + ">.list_comment").prepend(commentElement);

        $("#remove_comment_" + firebaseResponse.key).click(function () {
            $.ajax({
                url: '/comment/trip/remove',
                type: 'get',
                data: {trip_id: tripId, comment_id: firebaseResponse.key},
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
                    url: '/comment/trip/edit',
                    type: 'get',
                    data: {trip_id: tripId, comment_id: firebaseResponse.key, message: $(this).val()},
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
    // onListener change comment
    Ref.on('child_changed', function (firebaseResponse) {
        $("div#comment_content_"+firebaseResponse.key+ " .comment_content .content_text").html(firebaseResponse.val().content);
    });
    // onListener remove comment
    Ref.on('child_removed', function (firebaseResponse) {
        $("div#comment_box_"+firebaseResponse.key).remove();
    });
    // send comment
    $("input.comment_input").keypress(function (event) {
        if (event.which === 13) {
            var tripId  = $(this).data('article-id');
            var message = $(this).val();
            var commentInput = $(this);
            // var Ref = R.firebaseDB.ref('comments/trips/'+tripId).push();
            // Ref.set({
            //     username: "khanh",
            //     content: message,
            //     avatar: "",
            //     id: 1
            // });
            $.ajax({
                url: '/comment/trip',
                type: 'get',
                data: {trip_id: tripId, message: message},
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
};
