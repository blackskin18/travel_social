<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $posts = $this->postRepo->with('position')->with('user:id,avatar,name')->all();

        //return $posts;
        return view('home.new_feed')->with('posts', $posts);

    }
}
