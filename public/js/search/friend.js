$(function () {
    $(".btn_add_friend").click(function () {
        var buttonAddFriend = $(this);
        var friendId = $(this).data('friend-id');
        console.log(friendId);
        $.ajax({
            url: '/friends/send-request',
            type: 'post',
            data: {friend_id: friendId},
            success: function (responese) {
                buttonAddFriend.css('display', 'none');
                $("#sent_request_box_"+friendId).css('display', 'inline-block');
            },
            error: function () {
            }
        });
    });

    $(".btn_cancel_request_add_friend").click(function () {
        var friendId = $(this).data('friend-id');
        var buttonCancelRequest = $(this);
        $.ajax({
            url: '/friends/cancel-request',
            type: 'post',
            data: {friend_id: friendId},
            success: function (responese) {
                $("#btn_add_friend_"+friendId).css('display', 'inline-block');
                buttonCancelRequest.parent().parent().eq(0).css('display', 'none');
            },
            error: function () {
            }
        });
    });

    $(".btn_accept_add_friend_request").click(function () {
        var friendId = $(this).data('friend-id');
        var buttonAcceptRequest = $(this);
        $.ajax({
            url: '/friends/accept-request',
            type: 'post',
            data: {friend_id: friendId},
            success: function (responese) {
                $("#friend_box_"+friendId).css('display', 'inline-block');
                buttonAcceptRequest.parent().parent().eq(0).css('display', 'none');
            },
            error: function () {
            }
        });
    });
});
