<?php

namespace App\Http\Controllers;

use App\Repository\JoinRequestRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JoinRequestController extends Controller
{
    //
    protected $joinRequestRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JoinRequestRepository $joinRequestRepository
    ) {
        $this->middleware('auth');
        $this->joinRequestRepo = $joinRequestRepository;
    }

    public function addRequest(Request $request) {
        $authUser = Auth::user();
        $joinRequest = $this->joinRequestRepo->createOrDeleteRequest($authUser->id, $request->trip_id);
//            ->create(['trip_id'=>$request->trip_id, 'user_id' => $authUser->id, 'accepted' => 0]);
        return  $joinRequest;
    }
}
