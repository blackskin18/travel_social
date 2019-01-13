<?php

namespace App\Http\Controllers;

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

    protected $positionRepo;

    protected $postImageRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        PositionRepository $positionRepo,
        PostImageRepository $postImageRepo
    ) {

        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->positionRepo = $positionRepo;
        $this->postImageRepo = $postImageRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $posts = $this->postRepo->getList($user->id);

        return view('home.new_feed')->with('posts', $posts);

    }
}
