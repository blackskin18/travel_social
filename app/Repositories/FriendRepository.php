<?php

namespace App\Repository;

use App\Model\Comment;
use App\Model\Friend;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;

class FriendRepository extends BaseRepository
{
    const PENDING = 0;

    const ACCEPT = 1;

    const DECLINED = 2;

    const BLOCK = 3;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Friend";
    }

    public function createPendingRequest($userId, $friendId)
    {
        $this->deleteWhere(['user_one_id' => $friendId, 'user_two_id' => $userId]);
        $addFriendRequest = $this->firstOrCreate(['user_one_id' => $userId, 'user_two_id' => $friendId]);
        $addFriendRequest->type = self::PENDING;
        $addFriendRequest->save();

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
        $friendNotifications = Friend::where('user_two_id', $userId)->where('type', self::PENDING)->orWhere(function (Builder $query) use ($userId) {
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
        $friendRecord = Friend::where('seen', 0)->where('user_one_id', $userId)->orWhere('user_two_id', $userId)->where('seen', 0)->update(['seen'=> 1]);
        return $friendRecord;
    }
}
