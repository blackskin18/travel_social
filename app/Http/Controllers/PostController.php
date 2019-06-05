<?php

namespace App\Http\Controllers;

use App\Repository\FollowRepository;
use App\Repository\LikeRepository;
use App\Repository\TripRepository;
use App\Repository\TripUserRepository;
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
    CONST NORMAL = 1;

    CONST WITH_TRIP = 2;

    protected $postRepo;

    protected $userRepo;

    protected $positionRepo;

    protected $postImageRepo;

    protected $commentRepo;

    protected $likeRepo;

    protected $tripUserRepo;

    protected $tripRepo;

    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        PositionRepository $positionRepo,
        PostImageRepository $postImageRepo,
        FollowRepository $commentRepo,
        LikeRepository $likeRepo,
        TripRepository $tripRepo,
        TripUserRepository $tripUserRepo
    ) {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->positionRepo = $positionRepo;
        $this->postImageRepo = $postImageRepo;
        $this->commentRepo = $commentRepo;
        $this->likeRepo = $likeRepo;
        $this->tripUserRepo = $tripUserRepo;
        $this->tripRepo = $tripRepo;
    }

    public function create(CreatePostRequest $request)
    {
        $authUser = Auth::user();

        $post = $this->postRepo->create([
            'user_id' => $authUser->id,
            'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $request->post_description),
            'type' => $request->is_create_trip ? self::WITH_TRIP : self::NORMAL,
        ]);

        if ($request->is_create_trip) {
            $trip = $this->tripRepo->create([
                'user_id' => $authUser->id,
                'post_id' => $post->id,
                'title' => $request->trip_title,
                'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $request->post_description),
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ]);
            if ($request->member) {
                $this->tripUserRepo->inviteFriends($trip->id, $request->member);
            }
        }

        $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description, $request->time_arrive, $request->time_leave, $post->id, $trip->id ?? null);
        $this->postImageRepo->createMulti($request->photos, $post->id);

        return redirect()->back()->with('message', 'Operation Successful !');
    }

    public function getMapInfo(Request $request)
    {
        $postId = $request->post_id;
        if (! is_numeric($postId)) {
            return Response('Not found post Id', 204)->header('Content-Type', 'text/plain');
        }

        $positions = $this->positionRepo->findWhere(['post_id' => $postId]);
        $data = [
            'status' => 'success',
            'data' => $positions,
        ];

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
                return redirect()->back()->with('message', 'Operation Successful !');
            } else {
                throw new \Exception("you can't delete this post");
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
        //try {
        $post = $this->postRepo->with('position')->find($post_id);
        if (Auth::user()->can('update', $post) && $post) {
            if ($request->lat && $request->lng && $request->marker_description && count($request->lat) === count($request->lng) && count($request->lng) === count($request->marker_description)) {
                $this->positionRepo->deleteOldPositions($post->id, null);
                $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description, $request->time_arrive, $request->time_leave, $post->id);
                $post->description = $request->post_description;
                $post->save();
            }
            $this->postImageRepo->deleteWithArrayOfId($request->delete_images, $post->id);
            $this->postImageRepo->createMulti($request->photos, $post->id);

            return redirect()->route('post.detail', ['id' => $post->id]);
        } else {
            return "you can't edit this post";
        }
        //} catch (\Exception $e) {
        //    return $e->getMessage();
        //}
    }
}
