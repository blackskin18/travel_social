<?php

namespace App\Http\Controllers;

use App\Repository\FriendRepository;
use App\Repository\NotificationRepository;
use App\Repository\TripUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private $notificationRepo;

    private $friendRepo;
    private $tripUserRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        NotificationRepository $notificationRepo,
        FriendRepository $friendRepo,
        TripUserRepository $tripUserRepo
    ) {
        $this->middleware('auth');
        $this->notificationRepo = $notificationRepo;
        $this->friendRepo = $friendRepo;
        $this->tripUserRepo = $tripUserRepo;
    }

    public function getAll()
    {
        try {
            $authUser = Auth::user();
            $allNotification = $this->notificationRepo->getAllNotifyByUserId($authUser->id);
            return $allNotification;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function seenAllFriendNotify()
    {
        try {
            $authUser = Auth::user();
            $this->friendRepo->setSeenForAllNotify($authUser->id);
            return Response('successful', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function seenAllMemberNotify() {
        try {
            $authUser = Auth::user();
            $this->notificationRepo->setSeenAllForMemberNotify($authUser->id);
            return Response('successful', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function seenAllOtherNotify() {
        try {
            $authUser = Auth::user();
            $this->notificationRepo->setSeenAllForOtherNotify($authUser->id);
            return Response('successful', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
