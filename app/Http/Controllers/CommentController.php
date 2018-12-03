<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use LRedis;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getCommentInPost(Request $request)
    {
        $comments = $this->commentRepository->getCommentInPost($request->post_id);
        //$comments = $this->commentRepository->findWhere(['post_id' => $request->post_id]);

        return Response::json([
            'status' => 'success',
            'code' => 200,
            'data' => $comments,
        ], 200);
    }

    public function sendMessage(Request $request)
    {
        //$postId = $request->post_id;
        //$message = $request->message;
        $user = Auth::user();
        if ($this->commentRepository->storageComment($request->input(), $user)) {
            return Response::json([
                'status' => 'success',
                'code' => 200,
                'data' => [],
            ], 200);
        } else {
            return Response::json([
                'status' => 'fails',
                'code' => 201,
                'data' => [],
            ], 201);
        }

        //$redis = LRedis::connection();
        //$redis->publish('message', [ "comment" => $message, "post_id" => $postId]);

        //return redirect('writemessage');
    }
}
