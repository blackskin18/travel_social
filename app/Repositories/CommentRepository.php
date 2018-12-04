<?php

namespace App\Repository;

use App\Model\Comment;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

//use App\Repository\PostRepository;

class CommentRepository extends BaseRepository
{
    private $postRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Comment";
    }

    public function __construct(\Illuminate\Container\Container $app, PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        parent::__construct($app);
    }

    public function storageComment($input, $user)
    {
        $dataInsert['content'] = $input['comment_content'];
        $dataInsert['post_id'] = $input['post_id'];
        $dataInsert['user_id'] = $user->id;
        if ($input['post_id']) {
            if ($this->postRepository->find($input['post_id'])) {
                self::create($dataInsert);

                return true;
            }
        }

        return false;
    }

    public function getCommentInPost($postId)
    {
        $comment = Comment::where('post_id', $postId)->with('user')->orderBy('created_at', 'desc')->get();

        return $comment;
    }
}
