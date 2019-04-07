<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
//use LRedis;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->middleware('auth');
        $this->commentRepository = $commentRepository;
    }

    public function getCommentInPost(Request $request)
    {
        $comments = $this->commentRepository->getCommentInPost($request->post_id);


        return Response::json(['status' => 'success',
                               'code'   => 200,
                               'data'   => $comments,], 200);
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        if ($this->commentRepository->storageComment($request->input(), $user)) {
//            $redis = LRedis::connection();
            $countComment = count( $this->commentRepository->findWhere(['post_id'=>$request->post_id]));
//            $redis->publish('message', json_encode(['comment'     => $request->comment_content,
//                                                    'post_id'      => $request->post_id,
//                                                    'user_id'     => $user->id,
//                                                    'user_avatar' => $user->avatar,
//                                                    'count_comment' => $countComment,
//                                                    'user_name'   => $user->name]));

            return Response::json(['status' => 'success',
                                   'code'   => 200,
                                   'data'   => [],], 200);
        } else {
            return Response::json(['status' => 'fails',
                                   'code'   => 201,
                                   'data'   => [],], 201);
        }
    }
}
