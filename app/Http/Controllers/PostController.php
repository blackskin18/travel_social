<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\PositionRepository;
use App\Repository\PostImageRepository;


class PostController extends Controller
{
    private $user;
    protected $postRepo;
    protected $userRepo;
    protected $positionRepo;
    protected $postImageRepo;

    public function __construct(PostRepository $postRepo,
                                UserRepository $userRepo,
                                PositionRepository $positionRepo,
                                PostImageRepository $postImageRepo)
    {
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->positionRepo = $positionRepo;
        $this->postImageRepo = $postImageRepo;
    }

    public
    function create(CreatePostRequest $request)
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

        foreach ($request->photos as $photo) {
            $filename = $photo->store('');
            $photo->move(public_path('asset/images/post' . $post->id), $filename);
            $this->postImageRepo->create(["post_id" => $post->id, "image" => 'asset/images/post' . $post->id.'/'.$filename]);
        }

        return "ok";
    }
}
