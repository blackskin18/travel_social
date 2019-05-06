<?php

namespace App\Repository;

use App\Model\Comment;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class UserDeviceRepository extends BaseRepository
{
    private $postRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\UserDevice";
    }



}
