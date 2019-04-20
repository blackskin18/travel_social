<?php

namespace App\Repository;

use App\Model\Comment;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class JoinRequestRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\JoinRequest";
    }

    public function createOrDeleteRequest($userId, $tripId)
    {
        $joinRequestRecord = self::findWhere(['user_id'=>$userId, 'trip_id' =>$tripId])->first();
        if ($joinRequestRecord) {
            self::delete($joinRequestRecord->id);
            return ["type" => "delete_request"];
        } else {
            $joinRequest = self::create(['trip_id' => $tripId, 'user_id' => $userId, 'accepted' => 0]);
            $joinRequest->type = "create_request";
            return $joinRequest;
        }
    }
}
