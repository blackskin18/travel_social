<?php

namespace App\Service;

class DatabaseRealtimeService extends BaseFirebase
{
    public function storeComment($postId, $tripId, $authUser, $commentContent)
    {
        $database = $this->firebase->getDatabase();
        if ($postId) {
            $comment = $database->getReference('comments/posts/' . $postId);
        } elseif ($tripId) {
            $comment = $database->getReference('comments/trips/' . $tripId);
        }
        return $comment->push(
            [
                'avatar' => $authUser->avatar,
                'user_id' => $authUser->id,
                'content' => $commentContent,
                'user_name' => $authUser->name
            ]
        );

    }

    public function editComment($postId, $tripId, $commentId, $authUser, $commentContent)
    {
        $database = $this->firebase->getDatabase();

        if ($postId) {
            $comment = $database->getReference('comments/posts/' . $postId. '/' . $commentId);
        } elseif ($tripId) {
            $comment = $database->getReference('comments/trips/' . $tripId . '/' . $commentId);
        }
        return $comment->update(
            [
                'content' => $commentContent,
            ]
        );
    }

    public function removeComment($postId, $tripId, $commentId, $authUser)
    {
        $database = $this->firebase->getDatabase();
        if ($postId) {
            $comment = $database->getReference('comments/posts/' . $postId . '/' . $commentId)->remove();
        } elseif
        ($tripId) {
            $comment = $database->getReference('comments/trips/' . $tripId . '/' . $commentId)->remove();
        }
        return $comment;
    }

}
