<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Repository\PositionRepository;
use App\Repository\TripRepository;
use App\Repository\TripUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


use App\Repository\UserRepository;

class TripController extends Controller
{
    private $userRepo;
    private $tripRepo;
    private $tripUserRepo;
    private $positionRepo;

    public function __construct(
        UserRepository $userRepo,
        TripRepository $tripRepo,
        TripUserRepository $tripUserRepo,
        PositionRepository $positionRepo
    )
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->tripRepo = $tripRepo;
        $this->tripUserRepo = $tripUserRepo;
        $this->positionRepo = $positionRepo;
    }

    public function followPosition($tripId)
    {
        $trip = $this->tripRepo->with('userJoin')->find($tripId);
        $user = Auth::user();
        $members = $trip->userJoin;
        foreach ($members as $member) {
            if ($member->id === $user->id) {
//                dd($trip->position);
                return view('trip.index')->with('user_join',     $members)->with('trip', $trip);
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

//    public function store(CreateTripRequest $request)
    public function store(Request $request)
    {
        $authUser = Auth::user();
        $trip = $this->tripRepo->create([
            'user_id'    => $authUser->id,
            'title'      => $request->title,
            'time_start' => $request->time_start,
            'time_end'   => $request->time_end
        ]);

        $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description,false, $trip->id);
        $this->tripUserRepo->createMulti($trip, $request->member);
        return "true";
    }

    public function showDetail($tripId) {
        $trip = $this->tripRepo->with('user')->find($tripId);
        $tripUsers = $this->tripUserRepo->with('user')->findWhere(['trip_id' => $tripId]);

        return view('trip.detail')->with('trip', $trip)->with('tripUsers', $tripUsers);
    }

    public function showList() {
        $authUser = Auth::user();
        $tripsCreateByUser = $this->tripRepo->findWhere(['user_id' => $authUser->id]);
        $tripsUserFollow = $this->tripUserRepo->getTripsUserFollow($authUser->id);

        return view('trip.list')->with('tripsCreateByUser', $tripsCreateByUser)->with('tripsUserFollow', $tripsUserFollow);
    }

    public function userAccept($trip_id) {
        $userAuth = Auth::user();
        $this->tripUserRepo->updateFollowStatus($userAuth->id, $trip_id, 1);
        return redirect()->route('trip.detail', ['tripId' => $trip_id]);
    }

    public function userUnAccept($trip_id) {
        $userAuth = Auth::user();
        $this->tripUserRepo->updateFollowStatus($userAuth->id, $trip_id, 0);
        return redirect()->route('trip.detail', ['tripId' => $trip_id]);
    }

}
