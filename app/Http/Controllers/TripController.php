<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Repository\PositionRepository;
use App\Repository\TripRepository;
use App\Repository\InvitationRepository;
use App\Repository\TripUserRepository;
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

    public function __construct(
        UserRepository $userRepo,
        TripRepository $tripRepo,
        InvitationRepository $invitationRepo,
        PositionRepository $positionRepo,
        TripUserRepository $tripUserRepo
    ) {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->tripRepo = $tripRepo;
        $this->invitationRepo = $invitationRepo;
        $this->positionRepo = $positionRepo;
        $this->tripUserRepo = $tripUserRepo;
    }

    public function followPosition($tripId)
    {
        $trip = $this->tripRepo->with('userJoin')->find($tripId);
        $user = Auth::user();
        $members = $trip->userJoin;
        foreach ($members as $member) {
            if ($member->id === $user->id) {
                return view('trip.index')->with('user_join', $members)->with('trip', $trip);
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
        $this->invitationRepo->createMulti($trip, $request->member);

        return redirect()->route('trip.detail', ['tripId' => $trip->id]);
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
            $invitations = $this->invitationRepo->with('user')->findWhere(['trip_id' => $tripId]);
            $friends = $this->userRepo->findWhereNotIn('id', [Auth::user()->id]);
            return view('trip.detail')->with('trip', $trip)->with('invitations', $invitations)->with('friends', $friends);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showList()
    {
        try {
            $authUser = Auth::user();
            $tripsCreateByUser = $this->tripRepo->findWhere(['user_id' => $authUser->id]);
            $invitations = $this->invitationRepo->getTripsUserFollow($authUser->id);
            $joiningTrips = $this->tripUserRepo->with('trip')->findWhere(['user_id' => $authUser->id]);

            return view('trip.list')->with('tripsCreateByUser', $tripsCreateByUser)->with('invitations', $invitations)->with('joiningTrips', $joiningTrips);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function leave(Request $request)
    {
        try {
            $authUser = Auth::user();
            $this->tripUserRepo->deleteWhere(['trip_id' => $request->trip_id, 'user_id' => $authUser->id]);
            return Response("leave successful", 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($trip_id) {
        try {
            $authUser = Auth::user();
            $trip = $this->tripRepo->with('position')->find($trip_id);;
            if($trip && $authUser->can('update', $trip)) {
                return view('trip.edit')->with('trip', $trip)->with('authUser', $authUser);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $trip_id) {
        $authUser = Auth::user();
        $trip = $this->tripRepo->update([
            'user_id' => $authUser->id,
            'title' => $request->title,
            'description' => $request->description,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ], $trip_id);
        $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description, false, $trip->id);
        return redirect()->route('trip.show', ['trip_id'=> $trip_id]);
    }


}
