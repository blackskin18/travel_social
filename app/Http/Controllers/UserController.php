<?php

namespace App\Http\Controllers;

use App\Repository\FriendRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;
use App\Repository\PostRepository;

class UserController extends Controller
{
    protected $userRepository;

    private $friendRepo;

    protected $postRepository;

    public function __construct(
        UserRepository $userRepository,
        PostRepository $postRepository,
        FriendRepository $friendRepo
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->friendRepo = $friendRepo;
    }

    public function showPersonalPage($id)
    {
        $user = $this->userRepository->find($id);
        $authUser = Auth::user();
        $friendshipInfo = $this->friendRepo->getFriendshipInfo($authUser->id, $user->id);
        if ($user) {
            $posts = $this->postRepository->getListCreateByUser($user->id, $authUser->id);
            $allUser = $this->userRepository->findWhereNotIn('id', [$authUser->id]);
            return view('user.personal_page')
                ->with('user', $user)
                ->with('allUser', $allUser)
                ->with('friendshipInfo', $friendshipInfo)
                ->with('posts', $posts);
        }
    }

    public function displayInfo($id)
    {
        $authUser = Auth::user();
        $user = $this->userRepository->find($id);
        $friendshipInfo = $this->friendRepo->getFriendshipInfo($authUser->id, $user->id);

        return view('user.detail_info')->with('user', $user)->with('friendshipInfo', $friendshipInfo);
    }

    public function changeAvatar(Request $request)
    {
        $user = Auth::user();

        $photo = $request->file;
        $filename = $photo->store('');
        $photo->move(public_path('asset/images/avatar/'.$user->id), $filename);

        $user->avatar = $filename;
        $user->save();

        return Response([
            'status' => 'success',
            'data' => ['src_avatar' => 'asset/images/avatar/'.$user->id.'/'.$filename],
        ], 200)->header('Content-Type', 'text/plain');;
    }

    public function updateName(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->update(['name' => $request->value], $user->id);

            return Response([
                'status' => 'success',
                'data' => $request->value,
            ], 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateNickName(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->update(['nick_name' => $request->value], $user->id);

            return Response([
                'status' => 'success',
                'data' => $request->value,
            ], 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateEmail(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->update(['email' => $request->value], $user->id);

            return Response([
                'status' => 'success',
                'data' => $request->value,
            ], 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateAddress(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->update(['address' => $request->value], $user->id);

            return Response([
                'status' => 'success',
                'data' => $request->value,
            ], 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateGender(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->update(['gender' => $request->value], $user->id);

            return Response([
                'status' => 'success',
                'data' => $request->value,
            ], 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updatePhone(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->update(['phone' => $request->value], $user->id);

            return Response([
                'status' => 'success',
                'data' => $request->value,
            ], 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateDescription(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->update(['description' => $request->value], $user->id);

            return Response([
                'status' => 'success',
                'data' => $request->value,
            ], 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showListFriend($userId) {
        $authUser = Auth::user();
        $user = $this->userRepository->find($userId);
        $allFriends = $this->userRepository->getAllFriendOfUser($userId, $authUser->id);
        $friendShipWithCurrentUser = $this->friendRepo->getFriendshipInfo($userId, $authUser->id);
        return view('user.list_friend')
            ->with('friend_ship_with_current_user' , $friendShipWithCurrentUser)
            ->with('user_showing', $user)
            ->with('users', $allFriends['users'])
            ->with('friends', $allFriends['friends'])
            ->with('users_sent_request', $allFriends['users_sent_request'])
            ->with('users_receive_request', $allFriends['users_receive_request']);
    }
}
