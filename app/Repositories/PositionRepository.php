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

    public function createPositions(
        $lats,
        $lngs,
        $descriptions,
        $timeArrive,
        $timeLeave,
        $postId = null,
        $tripId = null
    ) {
        if (($postId || $tripId) && is_countable($lats) > 0) {
            for ($i = 0; $i < count($lats); $i++) {
                $this->create([
                    'post_id' => $postId,
                    'trip_id' => $tripId,
                    'lat' => $lats[$i],
                    'lng' => $lngs[$i],
                    'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $descriptions[$i]),
                    'time_arrive' => $timeArrive[$i] ? date('Y-m-d h:m:s', strtotime($timeArrive[$i])) : null,
                    'time_leave' => $timeLeave[$i] ? date('Y-m-d h:m:s', strtotime($timeLeave[$i])) : null,
                ]);
            }
        }
    }
}
