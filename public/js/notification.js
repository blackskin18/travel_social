// notification
$(function () {
    const SEEN = 1;
    const NOT_SEEN = 0;
    const INVITATION = 0;
    const JOIN_REQUEST = 1;
    const PENDING = 0;
    const ACCEPT = 1;
    const DECLINED = 2;

    const COMMENT_POST =0;
    const COMMENT_TRIP =1;
    const LIKE_POST =2;

    //FUNCTION GET ALL NOTIFICATION, CREATE HTML WHAT DISPLAY NOTIFICATIONS
    var getAllNotify = function () {
        $.ajax({
            url: '/notification/get-all',
            type: 'get',
            data: {},
            success: function (response) {
                //friend notification
                let friendNotifyBox = fetchFriendNotify(response.friend_notifications.notifications);
                $("#friend_notification_box>div").append(friendNotifyBox);
                if(parseInt(response.friend_notifications.count_notify_not_seen) > 0) {
                    $("div.count_friend_notify").text(response.friend_notifications.count_notify_not_seen);
                    $("div.count_friend_notify").css('display', 'block');
                }
                //trip member notification
                let memberdNotifyBox = fetchTripMemberNotify(response.trip_member_notification.notifications);
                $("#member_notification_box>div").append(memberdNotifyBox);
                if(parseInt(response.trip_member_notification.count_notify_not_seen) > 0) {
                    $("div.count_member_notify").text(response.trip_member_notification.count_notify_not_seen);
                    $("div.count_member_notify").css('display', 'block');
                }

                //other notification
                let otherNotifyBox = fetchOtherNotify(response.other_notification.notifications);
                $("#other_notification_box>div").append(otherNotifyBox);
                if(parseInt(response.other_notification.count_notify_not_seen) > 0) {
                    $("div.count_other_notify").text(response.other_notification.count_notify_not_seen);
                    $("div.count_other_notify").css('display', 'block');
                }
            },
            error: function () {
                alert('something error');
            }
        });
    };

    var fetchOtherNotify = function(notifications) {
        let htmlElement = `<h5 class="dropdown-header text-center border-bottom"> Thông báo </h5>`;
        for (let i in notifications) {
            // someone want to join your trip
            if (notifications[i].type == COMMENT_POST) {
                htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                    <div class="media">
                        <a href="/user/personal-page/${notifications[i].user_send.id}">
                            <img
                                src="${notifications[i].user_send.avatar ? '/asset/images/avatar/' + notifications[i].user_send.id + '/' + notifications[i].user_send.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                                alt="${notifications[i].user_send.name}" class="mr-3 rounded-circle"
                                style="width:60px;">
                        </a>                                    
                        <div class="media-body">
                            <div class="media-body">
                                <a href="/post/detail/${notifications[i].post_id}">
                                    <h3 class="mt-1 mb-0">${notifications[i].user_send.name}</h3>
                                    <p class="mb-0 text-dark"> ${notifications[i].user_receive.id === notifications[i].post.user_id ? "Đã bình luận trong bài viết của bạn": "Đã bình luận trong bài viết mà bạn đang theo dõi"}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                 </div>`;
            } else if (notifications[i].type == COMMENT_TRIP){
            } else if (notifications[i].type == LIKE_POST) {
            htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                    <div class="media">
                        <a href="/user/personal-page/${notifications[i].user_send.id}">
                            <img
                                src="${notifications[i].user_send.avatar ? '/asset/images/avatar/' + notifications[i].user_send.id + '/' + notifications[i].user_send.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                                alt="${notifications[i].user_send.name}" class="mr-3 rounded-circle"
                                style="width:60px;">
                        </a>                                    
                        <div class="media-body">
                            <div class="media-body">
                                <a href="/post/detail/${notifications[i].post_id}">
                                    <h3 class="mt-1 mb-0">${notifications[i].user_send.name}</h3>
                                    <p class="mb-0 text-dark"> Đã thích bài viết của bạn</p>
                                </a>
                            </div>
                        </div>
                    </div>
             </div>`;
            }
        }
        return htmlElement;
    }

    var fetchTripMemberNotify = function (notifications) {
        let htmlElement = `<h5 class="dropdown-header text-center border-bottom"> Thông báo về chuyến đi </h5>`;
        for (let i in notifications) {
            // someone want to join your trip
            if (notifications[i].type == JOIN_REQUEST && notifications[i].status == PENDING) {
                htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                     <a href="/trip/list">
                          <h3 class="text-center">
                                ${notifications[i].trip.title}
                          </h3>
                     </a>
                    <div class="media">
                        <a href="/user/personal-page/${notifications[i].user_id}">
                            <img
                                src="${notifications[i].user.avatar ? '/asset/images/avatar/' + notifications[i].user.id + '/' + notifications[i].user.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                                alt="${notifications[i].user.name}" class="mr-3 rounded-circle"
                                style="width:60px;">
                        </a>         
                            <div class="media-body">
                                <div class="media-body">
                                    <a href="/trip/list">
                                        <h3 class="mt-1 mb-0">${notifications[i].user.name}</h3>
                                        <p class="mb-0 text-dark"> Muốn tham gia vào chuyến đi của bạn </p>
                                    </a>                           
                                </div>
                            </div>
                            <div class="ml-4">
                                <button class="btn btn-primary w-100 btn_accept_join_request" 
                                    data-trip-id="${notifications[i].trip_id}"
                                    data-friend-id="${notifications[i].user.id}"> Đồng ý </button><br>
                                <button class="btn btn-danger w-100 btn_reject_request_join" 
                                    data-trip-id="${notifications[i].trip_id}"
                                    data-friend-id="${notifications[i].user.id}">Hủy</button>
                            </div>

                    </div>
                 </div>`;
            }
            // your join request was accepted
            if (notifications[i].type == JOIN_REQUEST && notifications[i].status == ACCEPT) {
                htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                     <a href="/trip/list">
                          <h3 class="text-center">
                                ${notifications[i].trip.title}
                          </h3>
                     </a>
                     <div class="media">
                        <img
                            src="${notifications[i].trip.user.avatar ? '/asset/images/avatar/' + notifications[i].trip.user.id + '/' + notifications[i].trip.user.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                            alt="${notifications[i].trip.user.name}" class="mr-3 rounded-circle"
                            style="width:60px;">
                            <div class="media-body">
                                <a href="/trip/list">
                                    <h3 class="mt-1 mb-0">${notifications[i].trip.user.name}</h3>
                                    <p class="mb-0 text-dark">Đã chấp nhận yêu cầu tham gia chuyến đi của bạn </p>
                                </a>
                            </div>
                        </div>
                </div>`;
            }
            // someone invite you to join their trip
            if (notifications[i].type == INVITATION && notifications[i].status == PENDING) {
                htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                     <a href="/trip/list">
                          <h3 class="text-center">
                                ${notifications[i].trip.title}
                          </h3>
                     </a>
                     <div class="media">
                          <img
                              src="${notifications[i].trip.user.avatar ? '/asset/images/avatar/' + notifications[i].trip.user.id + '/' + notifications[i].trip.user.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                              alt="${notifications[i].trip.user.name}" class="mr-3 rounded-circle"
                              style="width:60px;">
                          <div class="media-body">
                              <a href="/trip/list">
                                  <h3 class="mt-1 mb-0">${notifications[i].trip.user.name}</h3>
                                  <p class="mb-0 text-dark"> Mời bạn tham gia chuyến đi của họ</p>
                              </a>
                          </div>
                          <div class="ml-4">
                              <button class="btn btn-primary w-100 btn_accept_invitation" 
                                  data-trip-id="${notifications[i].trip_id}"
                                  data-friend-id="${notifications[i].user.id}"> Đồng ý </button><br>
                              <button class="btn btn-danger w-100 btn_reject_invitation"
                                  data-trip-id="${notifications[i].trip_id}" 
                                  data-friend-id="${notifications[i].user.id}">Hủy</button>
                          </div>
                     </div>
                </div>`;
            }
            // someone accept you invitation to join your trip
            if (notifications[i].type == INVITATION && notifications[i].status == ACCEPT) {
                htmlElement += `<div class="dropdown-item border-bottom pl-0 pr-0" style="background: ${notifications[i].seen == 0 ? "#dddddd": "#ffffff"}">
                     <a href="/trip/list">
                          <h3 class="text-center">
                                ${notifications[i].trip.title}
                          </h3>
                     </a>
                     <div class="media">
                        <img
                        src="${notifications[i].user.avatar ? '/asset/images/avatar/' + notifications[i].user.id + '/' + notifications[i].trip.avatar : '/asset/images/avatar/default/avatar_default.png'}"
                        alt="${notifications[i].user.name}" class="mr-3 rounded-circle"
                        style="width:60px;">
                        <div class="media-body">
                            <a href="/trip/list">
                                <h3 class="mt-1 mb-0">${notifications[i].user.name}</h3>
                                <p class="mb-0 text-dark">Đã chấp nhận lời mời của bạn </p>
                            </a>
                        </div>
                      </div>
                </div>`;
            }
        }
        return htmlElement;
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
        let numberNotification = parseInt($('div.count_friend_notify').text());
        if(numberNotification > 0) {
            $.ajax({
                url: '/notification/seen_all_friend_notification',
                type: 'get',
                success: function (responese) {
                    $('div.count_friend_notify').css('display', 'none');
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

    // SHOW MEMBER NOTIFICATION
    $("#btn_show_trip_member_notify").click(function () {
        let numberNotification = parseInt($('div.count_member_notify').text());
        if(numberNotification > 0) {
            $.ajax({
                url: '/notification/seen_all_member_notification',
                type: 'get',
                success: function (responese) {
                    console.log(responese);
                    $('div.count_member_notify').css('display', 'none');
                },
                error: function () {
                }
            });
        }

        $(this).popModal({
            html: $('#member_notification_box').html(),
            placement: 'bottomCenter',
            showCloseBut: true,
            onOkBut: function () {
            },
            onCancelBut: function () {
            },
            onLoad: function () {
                $(".btn_accept_invitation").click(function () {
                    var buttonAcceptFriend = $(this);
                    var friendId = $(this).data('friend-id');
                    var tripId = $(this).data('trip-id');
                    $.ajax({
                        url: '/trip/invitation/accept',
                        type: 'post',
                        data: {trip_id: tripId},
                        success: function (responese) {
                            buttonAcceptFriend.parent().parent().parent().css('display', 'none');
                            $(`.btn_accept_invitation[data-friend-id='${friendId}']`).eq(0).parent().parent().parent().remove();
                        },
                        error: function () {
                        }
                    });
                });
                $(".btn_reject_invitation").click(function () {
                    var buttonAcceptFriend = $(this);
                    var friendId = $(this).data('friend-id');
                    var tripId = $(this).data('trip-id');
                    $.ajax({
                        url: '/trip/invitation/reject_or_delete',
                        type: 'post',
                        data: {trip_id: tripId, _method: "DELETE"},
                        success: function (responese) {
                            buttonAcceptFriend.parent().parent().parent().css('display', 'none');
                            $(`.btn_accept_invitation[data-friend-id='${friendId}']`).eq(0).parent().parent().parent().remove();
                        },
                        error: function () {
                        }
                    });
                });
                $(".btn_accept_join_request").click(function () {
                    var buttonAcceptFriend = $(this);
                    var friendId = $(this).data('friend-id');
                    var tripId = $(this).data('trip-id');
                    $.ajax({
                        url: '/trip/join-request/accept',
                        type: 'post',
                        data: {trip_id: tripId, friend_id: friendId},
                        success: function (responese) {
                            buttonAcceptFriend.parent().parent().parent().css('display', 'none');
                            $(`.btn_accept_join_request[data-friend-id='${friendId}']`).eq(0).parent().parent().parent().remove();
                        },
                        error: function () {
                        }
                    });
                });
                $(".btn_reject_request_join").click(function () {
                    var buttonAcceptFriend = $(this);
                    var friendId = $(this).data('friend-id');
                    var tripId = $(this).data('trip-id');
                    $.ajax({
                        url: '/trip/join-request/reject_or_cancel',
                        type: 'post',
                        data: {trip_id: tripId, friend_id: friendId, _method: "DELETE"},
                        success: function (responese) {
                            buttonAcceptFriend.parent().parent().parent().css('display', 'none');
                            $(`.btn_accept_join_request[data-friend-id='${friendId}']`).eq(0).parent().parent().parent().remove();
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

    $("#btn_show_other_notify").click(function () {
        let numberNotification = parseInt($('div.count_other_notify').text());
        if(numberNotification > 0) {
            $.ajax({
                url: '/notification/seen_all_other_notification',
                type: 'get',
                success: function (responese) {
                    console.log(responese);
                    $('div.count_other_notify').css('display', 'none');
                },
                error: function () {
                }
            });
        }

        $(this).popModal({
            html: $('#other_notification_box').html(),
            placement: 'bottomCenter',
            showCloseBut: true,
            onOkBut: function () {
            },
            onCancelBut: function () {
            },
            onLoad: function () {
            },
            onClose: function () {
            }
        });
    });

        // GET ALL NOTIFICATION
    getAllNotify();
});
