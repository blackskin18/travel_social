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

    public function deleteOldPositions($post_id)
    {
        $this->deleteWhere(['post_id' => $post_id]);
    }

    public function createPositions($lats, $lngs, $descriptions, $postId = false, $tripId = false)
    {
        if($postId) {
            for ($i = 0; $i < count($lats); $i++) {
                $this->create(['post_id'     => $postId,
                    'lat'         => $lats[$i],
                    'lng'         => $lngs[$i],
                    'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $descriptions[$i]),]);
            }
        }
        if($tripId) {
            for ($i = 0; $i < count($lats); $i++) {
                $this->create(['trip_id'     => $tripId,
                    'lat'         => $lats[$i],
                    'lng'         => $lngs[$i],
                    'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $descriptions[$i]),]);
            }
        }
    }
}
