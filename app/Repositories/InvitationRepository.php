<?php

namespace App\Repository;

use App\Model\Comment;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class InvitationRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Invitation";
    }

//    public function __construct(\Illuminate\Container\Container $app, PostRepository $postRepository)
//    {
//        $this->postRepository = $postRepository;
//        parent::__construct($app);
//    }

    public function createMulti($trip, $members) {
        if($members) {
            foreach ($members as $member) {
                self::create(['trip_id' => $trip->id, 'user_id' => $member]);
            }
            self::create(['trip_id' => $trip->id, 'user_id' => $trip->user_id, 'accepted' => 1]);
        }
    }

    public function getTripsUserFollow($userId) {
        if($userId && is_numeric($userId)) {
            $invitations = self::with('trip')->findWhere(['user_id' => $userId]);
            foreach ($invitations as $key => $invitation) {
                if($invitation->trip->user_id === $userId) {
                    unset($invitations[$key]);
                }
            }
            return $invitations;
        } else {
            return [];
        }

    }
    public function updateInvitationStatus($userId, $tripId, $acceptedStatus) {
        $userTrip = self::findWhere(['user_id'=> $userId, 'trip_id'=>$tripId])->first();
        $userTrip->accepted = $acceptedStatus;
        $userTrip->save();

    }

}
