<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepository;
use App\Repository\LikeRepository;
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

    protected $commentRepo;

    protected $likeRepo;

    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        PositionRepository $positionRepo,
        PostImageRepository $postImageRepo,
        CommentRepository $commentRepo,
        LikeRepository $likeRepo
    ) {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->positionRepo = $positionRepo;
        $this->postImageRepo = $postImageRepo;
        $this->commentRepo = $commentRepo;
        $this->likeRepo = $likeRepo;
    }

    public function create(CreatePostRequest $request)
    {
        $user = Auth::user();
        $countPosition = count($request->lat);
        $post = $this->postRepo->create(["user_id"     => $user->id,
                                         'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $request->post_description),]);
        for ($i = 0; $i < $countPosition; $i++) {
            $this->positionRepo->create(['post_id'     => $post->id,
                                         'lat'         => $request->lat[$i],
                                         'lng'         => $request->lng[$i],
                                         'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $request->marker_description[$i]),]);
        }

        $this->postImageRepo->createMulti($request->photos, $post->id);

        return redirect()->back()->with('message', 'Operation Successful !');
        //return redirect()->route('personal.page', ['id' => $user->id]);
    }

    public function getMapInfo(Request $request)
    {
        $postId = $request->post_id;
        if (! is_numeric($postId)) {
            return Response('Not found post Id', 204)->header('Content-Type', 'text/plain');
        }

        $positions = $this->positionRepo->findWhere(['post_id' => $postId]);
        $data = ['status' => 'success',
                 'data'   => $positions];

        return Response($data, 200)->header('Content-Type', 'text/plain');
    }

    public function getDetailPost($postId)
    {
        $user = Auth::user();
        $post = $this->postRepo->getOne($postId, $user->id);

        return view('post.detail')->with('post', $post);
    }

    public function destroy($post_id)
    {
        try {
            $post = $this->postRepo->find($post_id);
            if (Auth::user()->can('delete', $post)) {
                $this->likeRepo->deleteWhere(['post_id' => $post_id]);
                $this->positionRepo->deleteWhere(['post_id' => $post_id]);
                $this->postImageRepo->deleteWhere(['post_id' => $post_id]);
                $this->commentRepo->deleteWhere(['post_id' => $post_id]);
                $this->postRepo->delete($post_id);

                //return Response(['status' => 'success', 'code' => 200], 200)->header('Content-Type', 'text/plain');
                return redirect('home');
            } else {
                return "you can't delete this post";
                //return Response(['status' => 'failure', 'code' => 201], 200)->header('Content-Type', 'text/plain');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($post_id)
    {
        try {
            $post = $this->postRepo->with('position')->find($post_id);
            if (Auth::user()->can('update', $post)) {
                return view('post.edit')->with('post', $post);
            } else {
                echo "you can't edit this post";
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $post_id)
    {
        try {
            $post = $this->postRepo->with('position')->find($post_id);

            if (Auth::user()->can('update', $post) && $post) {
                if (count($request->lat) === count($request->lng) && count($request->lng) === count($request->marker_description)) {
                    $this->positionRepo->deleteOldPositions($post->id);
                    $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description, $post->id);

                    $this->postImageRepo->deleteWithArrayOfId($request->delete_images, $post->id);
                    $this->postImageRepo->createMulti($request->photos, $post->id);

                    $post->description = $request->post_description;
                    $post->save();
                }

                return redirect()->route('post.detail', ['id' => $post->id]);
            } else {
                return "you can't edit this post";
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
