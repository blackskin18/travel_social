<?php

namespace App\Repository;

use App\Model\Comment;
use App\Model\Friend;
use App\Model\Notification;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class NotificationRepository extends BaseRepository
{
    private $friendRepo;

    private $tripRepo;

    private $tripUserRepo;

    private $followRepo;

    const COMMENT_POST = 0;

    const COMMENT_TRIP = 1;

    const LIKE = 2;

    const SEEN = 1;

    const NOT_SEEN = 0;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Notification";
    }

    public function __construct(
        \Illuminate\Container\Container $app,
        FriendRepository $friendRepo,
        TripRepository $tripRepo,
        TripUserRepository $tripUserRepo,
        FollowRepository $followRepo
    ) {
        $this->friendRepo = $friendRepo;
        $this->tripRepo = $tripRepo;
        $this->tripUserRepo = $tripUserRepo;
        $this->followRepo = $followRepo;
        parent::__construct($app);
    }

    public function getAllNotifyByUserId($userId)
    {
        $tripIds = $this->tripRepo->getTripIdsUserCreated($userId);
        $friendNotifications = $this->friendRepo->getNotificationByUserId($userId);
        $tripMemberNotifications = $this->tripUserRepo->getNotificationByUserId($userId, $tripIds);
        $otherNotifications = $this->getOtherNotification($userId);

        return [
            'friend_notifications' => $friendNotifications,
            'trip_member_notification' => $tripMemberNotifications,
            'other_notification' => $otherNotifications,
        ];
    }

    public function getOtherNotification($userId) {
        $notifications = $this->with([
            'post',
            'trip',
            'userSend',
            'userReceive',
        ])->findWhere(['user_receive' => $userId]);
        $countNotifyNotSeen = 0;
        foreach ($notifications as $notification) {
            if ($notification->seen === 0) {
                $countNotifyNotSeen++;
            }
        }
        return ['notifications' => $notifications, 'count_notify_not_seen' => $countNotifyNotSeen];
    }

    public function setSeenAllForMemberNotify($userId)
    {
        $tripIds = $this->tripRepo->getTripIdsUserCreated($userId);
        $this->tripUserRepo->setSeenForAllNotify($userId, $tripIds);
    }

    public function setSeenAllForOtherNotify($userId) {
        Notification::where('user_receive', $userId)->update(['seen' => self::SEEN]);
    }


    public function addCommentNotification($userSendId, $userOwnerId, $postId = null, $tripId = null)
    {
        if ($postId) {
            $usersFollowing = $this->followRepo->getAllUserFollowPost($userSendId, $postId);
            if ($userSendId != $userOwnerId) {
                $this->create(['user_send' => $userSendId, 'user_receive' => $userOwnerId, 'post_id' => $postId, 'type'=>self::COMMENT_POST]);
            }
            foreach ($usersFollowing as $userFollowing) {
                if ($userSendId != $userFollowing->user_id) {
                    $this->create([
                        'user_send' => $userSendId,
                        'user_receive' => $userFollowing->user_id,
                        'post_id' => $postId,
                        'type'=>self::COMMENT_POST
                    ]);
                }
            }
        } elseif ($tripId) {
            $usersFollowing = $this->followRepo->getAllUserFollowTrip($userSendId, null, $tripId);
            foreach ($usersFollowing as $userFollowing) {
                $this->create(['user_send' => $userSendId, 'user_receive' => $userFollowing->id, 'trip_id' => $postId]);
            }
        }
    }

    function addLikeNotification($userSendId, $post) {
        if($userSendId !== $post->user_id) {
            $this->create(['user_send' => $userSendId, 'user_receive' => $post->user_id, 'post_id' => $post->id, 'type' =>self::LIKE]);
        }
    }

    function removeLikeNotification($userSendId, $post) {
        $this->deleteWhere(['user_send' => $userSendId, 'user_receive' => $post->user_id, 'post_id' => $post->id, 'type' =>self::LIKE]);
    }


}
