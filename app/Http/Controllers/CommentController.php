<?php

namespace App\Http\Controllers;

use App\Repository\FollowRepository;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Service\DatabaseRealtimeService;
use App\Service\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Service\FirebaseService;

class CommentController extends Controller
{
    private $followRepo;
    private $DbRealtime;
    private $notifyRepo;
    private $postRepo;

    public function __construct(FollowRepository $followRepo, DatabaseRealtimeService $DbRealtime, NotificationRepository $notifyRepo, PostRepository $postRepo)
    {
        $this->middleware('auth');
        $this->DbRealtime = $DbRealtime;

        $this->followRepo = $followRepo;
        $this->notifyRepo = $notifyRepo;
        $this->postRepo = $postRepo;
    }

    public function storePostComment(Request $request) {
        $postId = $request->post_id;
        $post = $this->postRepo->find($postId);
        $authUser = Auth::user();
        $commentContent = $request->message;
        $this->DbRealtime->storeComment($postId, $authUser, $commentContent);
        if( $post->user_id !== $authUser->id) {
            $this->followRepo->followPost($authUser->id, $postId);
        }
        $this->notifyRepo->addCommentNotification($authUser->id, $post->user_id, $postId);
        $data = [
            "status" => 200,
            "type" => 'comment_successful',
        ];
        return Response($data, 200)->header('Content-Type', 'text/plain');
    }
}
