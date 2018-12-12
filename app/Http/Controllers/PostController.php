<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Response;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\PositionRepository;
use App\Repository\PostImageRepository;


class PostController extends Controller
{
    protected $postRepo;

    protected $userRepo;

    protected $positionRepo;

    protected $postImageRepo;

    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        PositionRepository $positionRepo,
        PostImageRepository $postImageRepo
    ) {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->positionRepo = $positionRepo;
        $this->postImageRepo = $postImageRepo;
    }

    public function create(CreatePostRequest $request)
    {
        $user = Auth::user();
        $countPosition = count($request->lat);
        $post = $this->postRepo->create([
            "user_id" => $user->id,
            'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $request->post_description),
        ]);
        for ($i = 0; $i < $countPosition; $i++) {
            $this->positionRepo->create([
                'post_id' => $post->id,
                'lat' => $request->lat[$i],
                'lng' => $request->lng[$i],
                'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $request->marker_description[$i]),
            ]);
        }

        if ($request->photos) {
            foreach ($request->photos as $photo) {
                $pathFile = Storage::put('public/images/post/'.$post->id, $photo);
                $pathFileArray = explode('/',$pathFile );
                $filename = $pathFileArray[count($pathFileArray) - 1];
                $this->postImageRepo->create([
                    "post_id" => $post->id,
                    "image" => $filename,
                ]);
            }
        }

        return redirect()->route('personal.page', ['id' => $user->id]);
    }

    public function getMapInfo(Request $request)
    {
        $postId = $request->post_id;
        if (! is_numeric($postId)) {
            return Response('Not found post Id', 204)->header('Content-Type', 'text/plain');
        }

        $positions = $this->positionRepo->findWhere(['post_id' => $postId]);
        $data = ['status' =>  'success',
                'data' => $positions];
        return Response($data, 200)->header('Content-Type', 'text/plain');
    }
}
