<?php

namespace App\Http\Controllers;

use App\Repository\FriendRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    const PENDING = 0;

    const ACCEPT = 1;

    const DECLINED = 2;

    const BLOCK = 3;

    private $userRepo;

    private $friendRepo;

    public function __construct(
        UserRepository $userRepo,
        FriendRepository $friendRepo
    ) {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->friendRepo = $friendRepo;
    }

    public function sendRequest(Request $request)
    {
        $authUser = Auth::user();
        if($authUser->id != $request->friend_id) {
            $friendRequest = $this->friendRepo->createPendingRequest($authUser->id, $request->friend_id);
            return Response($friendRequest, 200)->header('Content-Type', 'text/plain');
        }
    }

    public function cancelRequest(Request $request)
    {
        $authUser = Auth::user();
        $friendshipInfo = $this->friendRepo->getFriendshipInfo($authUser->id, $request->friend_id);

        if($friendshipInfo && $authUser->can('cancel', $friendshipInfo)) {
            $friendshipInfo->type = self::DECLINED;
            $friendshipInfo->save();
            return Response($friendshipInfo, 200)->header('Content-Type', 'text/plain');
        } else {
            return Response("you can cancel this request", 400)->header('Content-Type', 'text/plain');
        }
    }

    public function acceptRequest(Request $request) {
        $authUser = Auth::user();
        $friendshipInfo = $this->friendRepo->findWhere(['user_one_id' => $request->friend_id, 'user_two_id' => $authUser->id])->first();
        if($friendshipInfo) {
            $friendshipInfo->type = self::ACCEPT;
            $friendshipInfo->save();
            return Response($friendshipInfo, 200)->header('Content-Type', 'text/plain');
        }
        return "you can accept this request";
    }
}
