<?php

namespace App\Http\Controllers;

use App\Repository\JoinRequestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\PositionRepository;
use App\Repository\PostImageRepository;

class HomeController extends Controller
{
    protected $postRepo;

    protected $userRepo;

    protected $joinRequestRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        JoinRequestRepository $joinRequestRepo
    )
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->joinRequestRepo = $joinRequestRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authUser = Auth::user();
        $allUser = $this->userRepo->findWhereNotIn('id', [$authUser->id]);
        $posts = $this->postRepo->getList($authUser->id);
        return view('home.new_feed')->with('allUser', $allUser)->with('posts', $posts);

    }
}
