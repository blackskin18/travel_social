<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepository;
use App\Service\DatabaseRealtimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Service\FirebaseService;

class CommentController extends Controller
{
    private $commentRepository;
    private $DbRealtime;

    public function __construct(CommentRepository $commentRepository, DatabaseRealtimeService $DbRealtime)
    {
        $this->middleware('auth');
        $this->DbRealtime = $DbRealtime;
        $this->commentRepository = $commentRepository;
    }

    public function storePostComment(Request $request) {
        $postId = $request->post_id;
        $authUser = Auth::user();
        $commentContent = $request->message;
        $newComment = $this->DbRealtime->storeComment($postId, $authUser, $commentContent);
        return $newComment;
    }
}
