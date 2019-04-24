<?php

namespace App\Repository;

use App\Model\Comment;
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
    function model()
    {
        return "App\\Model\\TripUser";
    }

//    public function __construct(\Illuminate\Container\Container $app, PostRepository $postRepository)
//    {
//        $this->postRepository = $postRepository;
//        parent::__construct($app);
//    }
}
