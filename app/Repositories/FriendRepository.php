<?php

namespace App\Repository;

use App\Model\Comment;
use App\Model\Friend;
use App\Service\PushNotificationService;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use function PHPSTORM_META\type;
use Prettus\Repository\Eloquent\BaseRepository;

class FriendRepository extends BaseRepository
{
    const PENDING = 0;

    const ACCEPT = 1;

    const DECLINED = 2;

    const BLOCK = 3;

    private $pushNotificationService;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Friend";
    }

    public function __construct(
        \Illuminate\Container\Container $app,
        PushNotificationService $pushNotificationService
    ) {
        $this->pushNotificationService = $pushNotificationService;
        parent::__construct($app);
    }

    public function createPendingRequest($userId, $friendId)
    {
        $this->deleteWhere(['user_one_id' => $friendId, 'user_two_id' => $userId]);
        $addFriendRequest = $this->firstOrCreate(['user_one_id' => $userId, 'user_two_id' => $friendId]);
        $addFriendRequest->type = self::PENDING;
        //if($addFriendRequest->save()) {
        $this->pushNotificationService->addFriend($addFriendRequest);

        //}
        return $addFriendRequest;
    }

    public function getFriendshipInfo($userOne, $userTwo)
    {
        $friendship = $this->findWhere(['user_one_id' => $userOne, 'user_two_id' => $userTwo])->first();
        if ($friendship) {
            return $friendship;
        } else {
            $friendship = $this->findWhere(['user_one_id' => $userTwo, 'user_two_id' => $userOne])->first();
            return $friendship;
        }
        return $friendship;
    }

    public function getNotificationByUserId($userId)
    {
        $friendNotifications = Friend::where('user_two_id', $userId)->where('type', self::PENDING)->orWhere(function (
            Builder $query
        ) use ($userId) {
            $query->where('user_one_id', $userId)->where('type', self::ACCEPT)->where('seen', 0);
        })->with(['userOne', 'userTwo'])->get();
        $countNotifyNotSeen = 0;
        foreach ($friendNotifications as $friendNotification) {
            if ($friendNotification->seen === 0) {
                $countNotifyNotSeen++;
            }
        }

        return ['notifications' => $friendNotifications, 'count_notify_not_seen' => $countNotifyNotSeen];
    }

    public function setSeenForAllNotify($userId)
    {
        $friendRecord = Friend::where('seen', 0)->where('user_one_id', $userId)->orWhere('user_two_id', $userId)->where('seen', 0)->update(['seen' => 1]);

        return $friendRecord;
    }

    public function getAllFriendIdOfUser($userId)
    {
        $friends = Friend::where('user_two_id', $userId)->orWhere('user_one_id', $userId)->get();
        $friendIds = [];
        $userSentFriendRequest = [];
        $userReceiveFriendRequest = [];
        foreach ($friends as $friend) {
            if ($friend->type === self::ACCEPT) {
                array_push($friendIds, $friend->user_one_id === $userId ? $friend->user_two_id : $friend->user_one_id);
            } elseif ($friend->type === self::PENDING) {
                if ($friend->user_one_id === $userId) {
                    array_push($userReceiveFriendRequest, $friend->user_two_id);
                } else {
                    if ($friend->user_two_id === $userId) {
                        array_push($userSentFriendRequest, $friend->user_one_id);
                    }
                }
            }
        }
        return [
            'friend' => $friendIds,
            'user_sent_request' => $userSentFriendRequest,
            'user_receive_request' => $userReceiveFriendRequest,
        ];
    }

    public function getAllFriendShipOfUser($userId) {
        return Friend::where('user_two_id', $userId)->where('type', self::ACCEPT)->orWhere('user_one_id', $userId)->where('type', self::ACCEPT)->get();
    }

    public function getAllFriendOfUser($userId) {
        $allFriendShip =  Friend::where('user_two_id', $userId)->where('type', self::ACCEPT)->orWhere('user_one_id', $userId)->where('type', self::ACCEPT)->get();
        $userFriends = [];
        foreach ($allFriendShip as $friendShip) {
            if ($friendShip->user_one_id === $userId) {
                array_push($userFriends, $friendShip->userTwo);
            } elseif($friendShip->user_two_id === $userId) {
                array_push($userFriends, $friendShip->userOne);
            }
        }
        return $userFriends;
    }
}
