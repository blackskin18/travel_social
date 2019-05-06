<?php

namespace App\Service;

class DatabaseRealtimeService extends BaseFirebase
{
    public function storeComment($postId, $authUser, $commentContent) {
        $database = $this->firebase->getDatabase();
        $comment = $database->getReference('posts/'.$postId.'/comments')
            ->push(
                [
                    'avatar'=> $authUser->avatar,
                    'user_id'=> $authUser->id,
                    'content'=> $commentContent,
                    'user_name'=> $authUser->name
                ]
            );
        return $comment;
    }

}
