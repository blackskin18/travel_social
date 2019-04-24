<?php

namespace App\Repository;

use App\Model\Comment;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class TripRepository extends BaseRepository
{
    protected $invitationRepo;
    protected $tripUserRepo;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Trip";
    }

    public function __construct(\Illuminate\Container\Container $app, InvitationRepository $invitationRepo, TripUserRepository $tripUserRepo)
    {
        $this->invitationRepo = $invitationRepo;
        $this->tripUserRepo = $tripUserRepo;
        parent::__construct($app);
    }

    public function addMemberToTrip($userId, $tripId)
    {
        //remove invitation
        $this->invitationRepo->deleteWhere(['user_id'=> $userId, 'trip_id' => $tripId]);
        //add member to trip_user
        $this->tripUserRepo->firstOrCreate(['user_id'=> $userId, 'trip_id' => $tripId]);
    }

}
