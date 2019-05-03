// notification
$(function () {
    //FUNCTION GET ALL NOTIFICATION, CREATE HTML WHAT DISPLAY NOTIFICATIONS
    var getFriendNotify = function () {
        $.ajax({
            url: '/notification/get-all',
            type: 'get',
            data: {},
            success: function (response) {
                let friendNotifyBox = fetchFriendNotify(response.friend_notifications.notifications);
                $("#friend_notification_box>div").append(friendNotifyBox);
                if(parseInt(response.friend_notifications.count_notify_not_seen) > 0) {
                    $("div.number_friend_notify").text(response.friend_notifications.count_notify_not_seen);
                    $("div.number_friend_notify").css('display', 'block');
                }
            },
            error: function () {
                alert('something error');
            }
        });
    };
    var fetchFriendNotify = function (notifications) {
        let htmlElement = `<h5 class="dropdown-header text-center border-bottom">Lời mời kết bạn</h5>`;
        for (let i in notifications) {
            if (notifications[i].user_one_id == R.userId) {
                htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                     <div class="media">
                            <img
                                src="${notifications[i].user_two.avatar ? '/asset/images/avatar/' + notifications[i].user_two.id + '/' + notifications[i].user_two.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                                alt="${notifications[i].user_two.name}" class="mr-3 rounded-circle"
                                style="width:60px;">
                            <div class="media-body">
                                <h3 class="mt-1 mb-0">${notifications[i].user_two.name}</h3>  
                                <p class="mb-0 text-dark">đã chấp nhận lời mời kết bạn của bạn </p>
                            </div>
                        </div>
                </div>`;
            } else if (notifications[i].user_two_id == R.userId) {
                htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                                    <div class="media">
                                        <a href="/user/personal-page/${notifications[i].user_one_id}">
                                            <img
                                                src="${notifications[i].user_one.avatar ? '/asset/images/avatar/' + notifications[i].user_one.id + '/' + notifications[i].user_one.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                                                alt="${notifications[i].user_one.name}" class="mr-3 rounded-circle"
                                                style="width:60px;">
                                        </a>                                    
                                        <div class="media-body">
                                             <h3 class="mt-1 mb-0">${notifications[i].user_one.name}</h3>  
                                             <p class="mb-0 text-dark">đã gửi lời mời kết bạn cho bạn </p>
                                        </div>
                                        <div class="ml-4">
                                            <button class="btn btn-primary w-100 btn_accept_friend" 
                                                    data-friend-id="${notifications[i].user_one_id}"> Đồng ý </button><br>
                                            <button class="btn btn-danger w-100 btn_cancel_friend" 
                                                    data-friend-id="${notifications[i].user_one_id}">Hủy</button>
                                        </div>
                                    </div>
                             </div>`;
            }
        }
        return htmlElement;
    };

    // SHOW FRIEND NOTIFICATION
    $("#btn_show_friend_notify").click(function () {
        let numberNotification = parseInt($('div.number_friend_notify').text());
        if(numberNotification > 0) {
            $.ajax({
                url: '/notification/seen_all_friend_notification',
                type: 'post',
                success: function (responese) {
                    $('div.number_friend_notify').css('display', 'none');
                },
                error: function () {
                }
            });
        }

        $(this).popModal({
            html: $('#friend_notification_box').html(),
            placement: 'bottomCenter',
            showCloseBut: true,
            onOkBut: function () {
            },
            onCancelBut: function () {
            },
            onLoad: function () {
                $(".btn_accept_friend").click(function () {
                    var buttonAcceptFriend = $(this);
                    var friendId = $(this).data('friend-id');
                    $.ajax({
                        url: '/friends/accept-request',
                        type: 'post',
                        data: {friend_id: friendId},
                        success: function (responese) {
                            buttonAcceptFriend.parent().parent().parent().css('display', 'none');
                            $(`.btn_accept_friend[data-friend-id='${friendId}']`).eq(0).parent().parent().parent().remove();
                        },
                        error: function () {
                        }
                    });
                });
                $(".btn_cancel_friend").click(function () {
                    var buttoncancelFriend = $(this);
                    var friendId = $(this).data('friend-id');
                    $.ajax({
                        url: '/friends/cancel-request',
                        type: 'post',
                        data: {friend_id: friendId},
                        success: function (responese) {
                            buttoncancelFriend.parent().parent().parent().css('display', 'none');
                            $(`.btn_cancel_friend[data-friend-id='${friendId}']`).eq(0).parent().parent().parent().remove();
                        },
                        error: function () {
                        }
                    });
                });
            },
            onClose: function () {
            }
        });
    });

    // GET ALL NOTIFICATION
    getFriendNotify();
});
