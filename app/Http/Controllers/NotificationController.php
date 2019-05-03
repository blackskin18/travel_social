<?php

namespace App\Http\Controllers;

use App\Repository\FriendRepository;
use App\Repository\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationRepo;

    protected $friendRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        NotificationRepository $notificationRepo,
        FriendRepository $friendRepo
    ) {
        $this->middleware('auth');
        $this->notificationRepo = $notificationRepo;
        $this->friendRepo = $friendRepo;
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

    public function setSeenAllForFriendNotify()
    {
        try {
            $authUser = Auth::user();
            $this->friendRepo->setSeenForAllNotify($authUser->id);
            return Response('successful', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
