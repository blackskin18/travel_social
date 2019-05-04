<?php

namespace App\Repository;

use App\Model\Comment;
use App\Model\Friend;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class NotificationRepository extends BaseRepository
{
    private $friendRepo;

    private $tripRepo;

    private $tripUserRepo;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\TripUser";
    }

    public function __construct(
        \Illuminate\Container\Container $app,
        FriendRepository $friendRepo,
        TripRepository $tripRepo,
        TripUserRepository $tripUserRepo
    ) {
        $this->friendRepo = $friendRepo;
        $this->tripRepo = $tripRepo;
        $this->tripUserRepo = $tripUserRepo;
        parent::__construct($app);
    }

    public function getAllNotifyByUserId($userId)
    {
        $tripIds = $this->tripRepo->getTripIdsUserCreated($userId);
        $friendNotifications = $this->friendRepo->getNotificationByUserId($userId);
        $tripMemberNotifications = $this->tripUserRepo->getNotificationByUserId($userId, $tripIds);

        return [
            'friend_notifications' => $friendNotifications,
            'trip_member_notification' => $tripMemberNotifications,
        ];
    }

    public function setSeenAllForMemberNotify($userId) {
        $tripIds = $this->tripRepo->getTripIdsUserCreated($userId);
        $this->tripUserRepo->setSeenForAllNotify($userId, $tripIds);
    }

}
