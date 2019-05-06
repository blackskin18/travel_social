<?php

namespace App\Http\Controllers;

use App\Repository\TripRepository;
use App\Repository\TripUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberTripController extends Controller
{
    protected $tripRepo;

    protected $tripUserRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        TripRepository $tripRepo,
        TripUserRepository $tripUserRepo
    ) {
        $this->middleware('auth');
        $this->tripRepo = $tripRepo;
        $this->tripUserRepo = $tripUserRepo;
    }

    public function acceptInvitation(Request $request)
    {
        try {
            $userAuth = Auth::user();
            $this->tripUserRepo->acceptInvitation($request->trip_id, $userAuth);
            $data = [
                "code" => 200,
                "status" => "success",
                "type" => 'accept_invitation',
            ];
            return Response($data, 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function rejectOrDeleteInvitation(Request $request)
    {
        try {
            $userAuth = Auth::user();
            if ($request->member_id) {
                $this->tripUserRepo->declinedInvitation($request->trip_id, $request->member_id, $userAuth);
            } else {

                $this->tripUserRepo->declinedInvitation($request->trip_id, $userAuth->id, $userAuth);
            }
            $data = [
                "code" => 200,
                "status" => "success",
                "type" => 'decline_invitation',
            ];

            return Response($data, 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function inviteFriend(Request $request)
    {
        try {
            $trip = $this->tripRepo->find($request->trip_id);
            $authUser = Auth::user();
            $friendIds = $request->friend_ids;
            // just owner of trip can invite friend
            if ($trip && $authUser->can('update', $trip)) {
                $this->tripUserRepo->inviteFriends($trip->id, $friendIds);

                return redirect()->back()->with('message', 'Operation Successful !');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createJoinRequest(Request $request)
    {
        try {
            $authUser = Auth::user();
            if ($authUser !== $request->trip_id) {
                $joinRequest = $this->tripUserRepo->createJoinRequest($authUser->id, $request->trip_id);
                $data = [
                    "status" => 200,
                    "type" => 'create_join_request',
                ];
                return Response($data, 200)->header('Content-Type', 'text/plain');;
            } else {
                throw new \Exception("you can't join the trip what is created by you");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function rejectJoinRequest(Request $request)
    {
        try {
            $authUser = Auth::user();
            $trip = $this->tripRepo->find($request->trip_id);
            $friendId = $request->friend_id;
            if (!$friendId) {
                $this->tripUserRepo->rejectJoinRequest($authUser->id, $request->trip_id, $authUser);
            } else {
                $this->tripUserRepo->rejectJoinRequest($friendId, $request->trip_id, $authUser);
            }
            $data = [
                "status" => 200,
                "type" => 'decline_join_request',
            ];
            return Response($data, 200)->header('Content-Type', 'text/plain');;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function acceptJoinRequest(Request $request)
    {
        $authUser = Auth::user();
        try {
            $joinRequest = $this->tripUserRepo->acceptJoinRequest($request->friend_id, $request->trip_id, $authUser);
            $data = [
                "status" => 200,
                "type" => 'accept_join_request',
                "member" => $joinRequest->user,
            ];
            return Response($data, 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function leave(Request $request)
    {
        try {
            $authUser = Auth::user();
            if ($request->member_id) {
                $this->tripUserRepo->deleteWhere([
                    'trip_id' => $request->trip_id,
                    'user_id' => $request->member_id,
                    'status' => 1,
                ]);
            } else {
                $this->tripUserRepo->deleteWhere([
                    'trip_id' => $request->trip_id,
                    'user_id' => $authUser->id,
                    'status' => 1,
                ]);
            }
            $data = [
                "code" => 200,
                "status" => "success",
                "type" => 'leave_the_trip',
            ];
            return Response($data, 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
