<?php
namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository;

class PostImageRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\PostImage";
    }
}
