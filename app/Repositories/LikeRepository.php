<?php

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository;

class LikeRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Like";
    }

    public function createOrDelete($userId, $postId)
    {
        $like = $this->findWhere(['user_id' => $userId, 'post_id' => $postId]);
        if (count($like) > 0) {
            $this->delete($like[0]->id);
            return 'UNLIKE';
        } else {
            $this->create(['user_id'=>$userId, 'post_id'=>$postId]);
            return 'LIKE';
        }
    }
}
