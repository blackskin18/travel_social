window.onload = function () {
    $(".btn_reject_invitation").click(function () {
        let tripId = $(this).data('trip-id');
        $.ajax({
            url: '/trip/invitation/reject_or_delete',
            type: 'post',
            data: {
                _method: "DELETE",
                trip_id: tripId
            },
            success: function (response) {
                $("tr#invitation_trip_"+tripId).remove();
            },
            error: function () {
                alert('something error');
            }
        });
    });
    $(".btn_accept_invitation").click(function () {
        let tripId = $(this).data('trip-id');
        $.ajax({
            url: '/trip/invitation/accept',
            type: 'post',
            data: {
                trip_id: tripId
            },
            success: function (response) {
                $("tr#invitation_trip_"+tripId).remove();
            },
            error: function () {
                alert('something error');
            }
        });
    });

    $(".btn_leave_trip").click(function () {
        let tripId = $(this).data('trip-id');
        $.ajax({
            url: '/trip/leave',
            type: 'post',
            data: {
                _method: "DELETE",
                trip_id: tripId
            },
            success: function (response) {
                $("tr#joining_trip_"+tripId).remove();
            },
            error: function () {
                alert('something error');
            }
        });
    });
};
