<?php

namespace App\Repository;

use App\Model\Like;
use Prettus\Repository\Eloquent\BaseRepository;

class LikeRepository extends BaseRepository
{
    private $notificationRepo;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Like";
    }

    public function __construct(
        \Illuminate\Container\Container $app,
        NotificationRepository $notificationRepo
    ) {
        $this->notificationRepo = $notificationRepo;
        parent::__construct($app);
    }

    public function createOrDelete($userId, $post)
    {
        $like = $this->findWhere(['user_id' => $userId, 'post_id' => $post->id]);
        if (count($like) > 0) {
            $this->delete($like[0]->id);
            $this->notificationRepo->removeLikeNotification($userId, $post);

            return 'UNLIKE';
        } else {
            $this->create(['user_id' => $userId, 'post_id' => $post->id]);
            $this->notificationRepo->addLikeNotification($userId, $post);

            return 'LIKE';
        }
    }
}
