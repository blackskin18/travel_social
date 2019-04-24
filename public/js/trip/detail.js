window.onload = function () {

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
    $(".btn_accept_request_join").click(function () {
        let userJoinId = $(this).data('user-join-id');
        let tripId = $(this).data('trip-id');
        $.ajax({
            url: '/trip/join-request/accept',
            type: 'get',
            data: {
                user_join_id: userJoinId,
                trip_id: tripId
            },
            success: function (response) {
                // $("tr#user_invited_"+memberId).remove();
            },
            error: function () {
                alert('something error');
            }
        });
    });
};
