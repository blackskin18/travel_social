<?php

namespace App\Repository;

use App\Model\Comment;
use App\Model\TripUser;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class TripUserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    const SEEN = 1;

    const NOT_SEEN = 0;

    const INVITATION = 0;

    const JOIN_REQUEST = 1;

    const PENDING = 0;

    const ACCEPT = 1;

    const DECLINED = 2;

    function model()
    {
        return "App\\Model\\TripUser";
    }

    public function inviteFriends($tripId, $friendIds)
    {
        for ($i = 0; $i < count($friendIds); $i++) {
            if (! $this->findWhere(['trip_id' => $tripId, 'user_id' => $friendIds[$i]])->first()) {
                $this->firstOrCreate([
                    'trip_id' => $tripId,
                    'user_id' => $friendIds[$i],
                    'type' => self::INVITATION,
                    'status' => self::PENDING,
                ]);
            }
        }
    }

    public function acceptInvitation($tripId, $user)
    {
        $invitation = $this->findWhere([
            'trip_id' => $tripId,
            'user_id' => $user->id,
            'type' => self::INVITATION,
            'status' => self::PENDING,
        ])->first();
        if ($invitation && $user->can('acceptInvitation', $invitation)) {
            $invitation->status = self::ACCEPT;
            $invitation->save();

            return $invitation;
        } else {
            throw new \Exception("You can't update this invitation");
        }
    }

    public function declinedInvitation($tripId, $memberId, $authUser)
    {
        $invitation = $this->findWhere([
            'trip_id' => $tripId,
            'user_id' => $memberId,
            'type' => self::INVITATION,
            'status' => self::PENDING,
        ])->first();
        if ($invitation && $authUser->can('declinedInvitation', $invitation)) {
            $this->delete($invitation->id);
        } else {
            throw new \Exception("You can't decline this invitation");
        }
    }

    public function getAllTripUserBeInvited($userId)
    {
        return $this->findWhere(['user_id' => $userId, 'type' => self::INVITATION, 'status' => self::PENDING]);
    }

    public function getAllTripUserBeJoining($userId)
    {
        return $this->with('trip')->findWhere(['user_id' => $userId, 'status' => self::ACCEPT]);
    }

    public function createJoinRequest($userId, $tripId)
    {
        $requestRecord = $this->findWhere(['trip_id' => $tripId, 'user_id' => $userId])->first();
        if ($requestRecord) {
            throw new \Exception("you sent the request to join this trip or someone invited you join this trip");
        } else {
            return $this->create([
                'trip_id' => $tripId,
                'user_id' => $userId,
                'type' => self::JOIN_REQUEST,
                'status' => self::PENDING,
            ]);
        }
    }

    public function rejectJoinRequest($userId, $tripId, $authUser)
    {
        $joinRequest = $this->findWhere(['trip_id' => $tripId, 'user_id'=>$userId, 'type'=>self::JOIN_REQUEST, 'status'=>self::PENDING])->first();
        if($joinRequest && $authUser->can('declineJoinRequest', $joinRequest)) {
            $this->delete($joinRequest->id);
            return "true";
        } else {
            throw new \Exception("you sent the request to join this trip or someone invited you join this trip");
        }
    }

    public function acceptJoinRequest($userId, $tripId, $authUser) {
        $joinRequest = $this->findWhere(['trip_id' => $tripId, 'user_id'=>$userId, 'type'=>self::JOIN_REQUEST, 'status'=>self::PENDING])->first();
        if($joinRequest && $authUser->can('acceptJoinRequest', $joinRequest)) {
            $joinRequest->status = self::ACCEPT;
            $joinRequest->save();
            return $joinRequest;
        } else {
            throw new \Exception("You can't update this join request");
        }
    }

    public function getAllInvitationOfTrip($tripId) {
        return $this->with('user')->findWhere(['trip_id' => $tripId,'type'=>self::INVITATION, 'status'=>self::PENDING]);
    }

    public function getAllJoinRequestOfTrip($tripId) {
        return $this->with('user')->findWhere(['trip_id' => $tripId,'type'=>self::JOIN_REQUEST, 'status'=>self::PENDING]);
    }

    public function getAllMemberOfTrip($tripId) {
        return $this->with('user')->findWhere(['trip_id' => $tripId,'status'=>self::ACCEPT]);
    }

}
