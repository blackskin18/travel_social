<?php

namespace App\Repository;

use App\Model\Comment;
use App\Model\Follow;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class FollowRepository extends BaseRepository
{
    private $postRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Follow";
    }

    public function followPost($userId, $postId)
    {
        $this->firstOrCreate(['user_id' => $userId, 'post_id' => $postId]);
    }

    public function followTrip($userId, $tripId) {
        $this->firstOrCreate(['user_id' => $userId, 'trip_id' => $tripId]);
    }

    public function getAllUserFollowPost ($userId, $postId){
        $usersFollowing =  Follow::where('post_id', $postId)->where('user_id' , '!=', $userId)->get();
        return $usersFollowing;
    }

    public function getAllUserFollowTrip($userId, $tripId = null) {
        $usersFollowing =  Follow::where('trip_id', $tripId)->where('user_id' , '!=', $userId);
        return $usersFollowing;
    }
}
