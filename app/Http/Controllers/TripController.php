<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Repository\PositionRepository;
use App\Repository\TripRepository;
use App\Repository\TripUserRepository;
use App\Service\DatabaseRealtimeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Repository\UserRepository;

class TripController extends Controller
{
    private $userRepo;

    private $tripRepo;

    private $invitationRepo;

    private $positionRepo;

    private $tripUserRepo;

    private $dbRealtime;

    public function __construct(
        UserRepository $userRepo,
        TripRepository $tripRepo,
        PositionRepository $positionRepo,
        TripUserRepository $tripUserRepo,
        DatabaseRealtimeService $dbRealtime
    ) {
        $this->middleware('auth');
        $this->dbRealtime = $dbRealtime;
        $this->userRepo = $userRepo;
        $this->tripRepo = $tripRepo;
        $this->positionRepo = $positionRepo;
        $this->tripUserRepo = $tripUserRepo;
    }

    public function followPosition($tripId)
    {
        $trip = $this->tripRepo->with('tripUser')->find($tripId);
        $authUser = Auth::user();
        $members = $trip->tripUser;
        if($authUser->id === $trip->user_id) {
            $firebaseToken = $this->dbRealtime->getFirebaseToken($trip->id);
            return view('trip.index')->with('user_join', $members)->with('trip', $trip)->with('firebase_token', $firebaseToken);
        }
        foreach ($members as $member) {
            if ($member->id === $authUser->id) {
                $firebaseToken = $this->dbRealtime->getFirebaseToken($trip->id);
                return view('trip.index')->with('user_join', $members)->with('trip', $trip)->with('firebase_token', $firebaseToken);
            }
        }
        return "Error";
    }

    public function create()
    {
        $authUser = Auth::user();
        $users = $this->userRepo->findWhereNotIn('id', [$authUser->id]);

        return view('trip.create')->with('users', $users);
    }

    public function store(CreateTripRequest $request)
    {
        $authUser = Auth::user();
        $trip = $this->tripRepo->create([
            'user_id' => $authUser->id,
            'title' => $request->title,
            'description' => $request->description,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ]);

        $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description, false, $trip->id);
        if($request->member) {
            $this->tripUserRepo->inviteFriends($trip->id, $request->member);
        }
        return redirect()->route('trip.show', ['tripId' => $trip->id]);
    }

    public function delete(Request $request)
    {
        try {
            $trip = $this->tripRepo->find($request->trip_id);
            if ($trip && Auth::user()->can('delete', $trip)) {
                $this->invitationRepo->deleteWhere(['trip_id' => $request->trip_id]);
                $this->positionRepo->deleteWhere(['trip_id' => $request->trip_id]);
                $this->tripRepo->delete($request->trip_id);

                return redirect()->route('trip.list');
            } else {
                throw new \Exception("You can't delete this trip");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($tripId)
    {
        try {
            $trip = $this->tripRepo->with('tripUser')->with('user')->find($tripId);
            //$invitations = $this->tripUserRepo->with('user')->findWhere(['trip_id' => $tripId]);
            $invitations = $this->tripUserRepo->getAllInvitationOfTrip($tripId);
            $members = $this->tripUserRepo->getAllMemberOfTrip($tripId);
            $joinRequests = $this->tripUserRepo->getAllJoinRequestOfTrip($tripId);
            $friends = $this->userRepo->findWhereNotIn('id', [Auth::user()->id]);

            return view('trip.detail')->with([
                'trip' => $trip,
                'members' => $members,
                'joinRequests' => $joinRequests,
                'invitations'=> $invitations,
                'friends'=> $friends
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showList()
    {
        try {
            $authUser = Auth::user();
            $tripsCreateByUser = $this->tripRepo->findWhere(['user_id' => $authUser->id]);
            $invitations = $this->tripUserRepo->getAllTripUserBeInvited($authUser->id);
            $joiningTrips = $this->tripUserRepo->getAllTripUserBeJoining($authUser->id);

            //$joiningTrips = $this->tripUserRepo->with('trip')->findWhere(['user_id' => $authUser->id]);

            return view('trip.list')->with('tripsCreateByUser', $tripsCreateByUser)->with('invitations', $invitations)->with('joiningTrips', $joiningTrips);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //public function leave(Request $request)
    //{
    //    try {
    //        $authUser = Auth::user();
    //        $this->tripUserRepo->deleteWhere([
    //            'trip_id' => $request->trip_id,
    //            'user_id' => $authUser->id,
    //            'status' => 1,
    //        ]);
    //        $data = [
    //            "code" => 200,
    //            "status" => "success",
    //            "type" => 'leave_the_trip',
    //        ];
    //        return Response($data, 200)->header('Content-Type', 'text/plain');
    //    } catch (\Exception $e) {
    //        return $e->getMessage();
    //    }
    //}

    public function edit($trip_id)
    {
        try {
            $authUser = Auth::user();
            $trip = $this->tripRepo->with('position')->find($trip_id);;
            if ($trip && $authUser->can('update', $trip)) {
                return view('trip.edit')->with('trip', $trip)->with('authUser', $authUser);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $trip_id)
    {
        $authUser = Auth::user();
        $trip = $this->tripRepo->update([
            'user_id' => $authUser->id,
            'title' => $request->title,
            'description' => $request->description,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ], $trip_id);
        $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description, false, $trip->id);

        return redirect()->route('trip.show', ['trip_id' => $trip_id]);
    }
}
