<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\InvitationRepository;

class InvitationController extends Controller
{
    protected $invitationRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        InvitationRepository $invitationRepo
    ) {
        $this->middleware('auth');
        $this->invitationRepo = $invitationRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function acceptOrReject(Request $request)
    {
        $userAuth = Auth::user();
        $invitation = $this->invitationRepo->findWhere(['trip_id' => $request->trip_id, 'user_id' => $userAuth->id])->first();

        if ($invitation && Auth::user()->can('update', $invitation)) {
            if($invitation->accepted) {
                $this->invitationRepo->updateInvitationStatus($userAuth->id, $invitation->trip_id, 0);
            } else {
                $this->invitationRepo->updateInvitationStatus($userAuth->id, $invitation->trip_id, 1);
            }
            return redirect()->back()->with('message', 'Operation Successful !');
        } else {
            throw new \Exception("You can't update this invitation");
        }
    }

    public function delete(Request $request)
    {
        $userAuth = Auth::user();
        $invitation = $this->invitationRepo->findWhere(['trip_id' => $request->trip_id, 'user_id' => $userAuth->id])->first();
        if ($invitation && Auth::user()->can('delete', $invitation)) {
            $this->invitationRepo->delete($invitation->id);
            return redirect()->back()->with('message', 'Operation Successful !');
        }else {
            throw new \Exception("You can't delete this invitation");
        }
    }

}
