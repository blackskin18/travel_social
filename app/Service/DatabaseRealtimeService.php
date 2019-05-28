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

    public function editComment($postId, $commentId, $authUser, $commentContent) {
        $database = $this->firebase->getDatabase();
        $comment = $database->getReference('posts/'.$postId.'/comments/'.$commentId)
            ->update(
                [
                    'content'=> $commentContent,
                ]
            );
        return $comment;
    }

    public function removeComment($postId, $commentId, $authUser) {
        $database = $this->firebase->getDatabase();
        $comment = $database->getReference('posts/'.$postId.'/comments/'.$commentId)->remove();
        return $comment;
    }

}
