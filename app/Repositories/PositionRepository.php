<?php
namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository;

class PositionRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Position";
    }
}
