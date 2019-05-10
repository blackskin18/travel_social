<?php

namespace App\Http\Controllers;

use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private $likeRepository;

    private $postRepository;

    public function __construct(LikeRepository $likeRepository, PostRepository $postRepository)
    {
        $this->middleware('auth');
        $this->likeRepository = $likeRepository;
        $this->postRepository = $postRepository;
    }

    public function addLike(Request $request)
    {
        try {
            $user = Auth::user();
            $post = $this->postRepository->find($request->post_id);
            if ($post) {
                $message = $this->likeRepository->createOrDelete($user->id, $post);
                $data = ['code'   => 200,
                         'status' => 'success',
                         'data'     => ['message'    => $message,
                                      'count_like' => count($post->like)]];
                return Response($data, 200)->header('Content-Type', 'text/plain');
            }

            return Response(['code'   => 201,
                             'status' => 'error'], 201)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
