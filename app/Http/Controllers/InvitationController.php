<?php

namespace App\Http\Controllers;

use App\Repository\JoinRequestRepository;
use App\Repository\TripRepository;
use App\Repository\TripUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\InvitationRepository;

class InvitationController extends Controller
{
    protected $invitationRepo;

    protected $tripRepo;

    protected $joinRequestRepo;

    protected $tripUserRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        InvitationRepository $invitationRepo,
        TripRepository $tripRepo,
        JoinRequestRepository $joinRequestRepo,
        TripUserRepository $tripUserRepo
    ) {
        $this->middleware('auth');
        $this->invitationRepo = $invitationRepo;
        $this->tripRepo = $tripRepo;
        $this->joinRequestRepo = $joinRequestRepo;
        $this->tripUserRepo = $tripUserRepo;
    }

    public function accept(Request $request)
    {
        $userAuth = Auth::user();
        $invitation = $this->invitationRepo->findWhere([
            'trip_id' => $request->trip_id,
            'user_id' => $userAuth->id,
        ])->first();
        if ($invitation && Auth::user()->can('update', $invitation)) {
            $this->tripRepo->addMemberToTrip($userAuth->id, $request->trip_id);

            return redirect()->back()->with('message', 'Operation Successful !');
        } else {
            throw new \Exception("You can't update this invitation");
        }
    }

    public function rejectOrDelete(Request $request)
    {
        $userAuth = Auth::user();
        if ($request->member_id) {
            $invitation = $this->invitationRepo->findWhere([
                'trip_id' => $request->trip_id,
                'user_id' => $request->member_id,
            ])->first();
        } else {
            $invitation = $this->invitationRepo->findWhere([
                'trip_id' => $request->trip_id,
                'user_id' => $userAuth->id,
            ])->first();
        }
        if ($invitation && Auth::user()->can('delete', $invitation)) {
            $this->invitationRepo->delete($invitation->id);

            return ["code" => 200, "status" => "success"];
        } else {
            throw new \Exception("You can't delete this invitation");
        }
    }

    public function inviteFriend(Request $request)
    {
        try {
            $trip = $this->tripRepo->find($request->trip_id);
            $authUser = Auth::user();
            $friendIds = $request->friend_ids;

            if ($trip && $authUser->can('update', $trip)) {
                for ($i = 0; $i < count($friendIds); $i++) {
                    if($this->joinRequestRepo->deleteWhere(['trip_id' => $trip->id, 'user_id' => $friendIds[$i]])) {
                        $this->tripUserRepo->firstOrCreate(['trip_id' => $trip->id, 'user_id' => $friendIds[$i]]);
                    } else {
                        $this->invitationRepo->firstOrCreate(['trip_id' => $trip->id, 'user_id' => $friendIds[$i]]);
                    }
                }
                return redirect()->back()->with('message', 'Operation Successful !');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
