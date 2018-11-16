<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\PositionRepository;

class PostController extends Controller
{
    private $user;
    protected $postRepo;
    protected $userRepo;
    protected $positionRepo;

    public function __construct(PostRepository $postRepo,
                                UserRepository $userRepo,
                                PositionRepository $positionRepo)
    {
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->positionRepo = $positionRepo;
    }

    public function create(CreatePostRequest $request)
    {
        $user = Auth::user();
        $countPosition = count($request->lat);
        $post = $this->postRepo->create(["user_id"     => $user->id,
                                         'description' => $request->post_description]);
        for ($i = 0; $i < $countPosition; $i++) {
            $this->positionRepo->create(['post_id'     => $post->id,
                                         'lat'         => $request->lat[$i],
                                         'lng'         => $request->lng[$i],
                                         'description' => $request->marker_description[$i]]);
        }
        return "ok";
    }
}
