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

};
