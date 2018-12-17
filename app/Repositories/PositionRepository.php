<?php

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository;

class PositionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Position";
    }

    //public function deleteWithPost($post_id)
    //{
    //    if ($this->deleteWhere(['post_id' => $post_id])) {
    //
    //}
}
