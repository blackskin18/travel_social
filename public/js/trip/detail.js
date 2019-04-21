window.onload = function () {
    $(".btn_show_map").click(function () {
        let myMap = new MapCustom();
        let tripId = $(this).data('trip-id');
        console.log(tripId);
        myMap.initMap();
        myMap.addListenerShowMap("div#trip_info_position_" + tripId);
        $("div.map_box").css("display", "block");
    });

    $(".delete_member_invited").click(function () {
        let memberId = $(this).data('member-id');
        let tripId = $(this).data('trip-id');
        $.ajax({
            url: '/trip/invitation/delete',
            type: 'get',
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
