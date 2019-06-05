<?php

namespace App\Http\Controllers;

use App\Repository\FriendRepository;
use App\Repository\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class HomeController extends Controller
{
    protected $postRepo;

    protected $userRepo;

    protected $notificationRepo;

    protected $friendRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        NotificationRepository $notificationRepo,
        FriendRepository $friendRepo
    )
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->notificationRepo = $notificationRepo;
        $this->friendRepo = $friendRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authUser = Auth::user();
        //$allUser = $this->userRepo->findWhereNotIn('id', [$authUser->id]);
        $allUser = $this->friendRepo->getAllFriendOfUser($authUser->id);
        $posts = $this->postRepo->getList($authUser->id);
        return view('home.new_feed')->with('allUser', $allUser)->with('posts', $posts);
    }
}
