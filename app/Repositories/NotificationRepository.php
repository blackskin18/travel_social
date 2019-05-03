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

    private $joinRequestRepo;

    private $tripRepo;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Comment";
    }

    public function __construct(
        \Illuminate\Container\Container $app,
        FriendRepository $friendRepo,
        TripRepository $tripRepo
    ) {
        $this->friendRepo = $friendRepo;
        $this->tripRepo = $tripRepo;
        parent::__construct($app);
    }

    public function getAllNotifyByUserId($userId)
    {
        $tripIds = $this->tripRepo->getTripIdsUserCreated($userId);
        $friendNotification = $this->friendRepo->getNotificationByUserId($userId);

        return [
            'friend_notifications' => $friendNotification,
        ];
    }
}
