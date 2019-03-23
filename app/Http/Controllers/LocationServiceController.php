<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Repository\CommentRepository;
use App\Repository\LikeRepository;
use App\Repository\TripRepository;
use App\Repository\TripUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Response;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\PositionRepository;
use App\Repository\PostImageRepository;

class LocationServiceController extends Controller
{
    private $userRepo;
    private $tripRepo;
    private $tripUserRepo;

    public function __construct(
        UserRepository $userRepo,
        TripRepository $tripRepo,
        TripUserRepository $tripUserRepo
    )
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->tripRepo = $tripRepo;
        $this->tripUserRepo = $tripUserRepo;
    }

    public function index()
    {
        return view('location_service.index');
    }

    public function create()
    {
        $users = $this->userRepo->all();
        return view('trip.create')->with('users', $users);
    }

    public function store(CreateTripRequest $request)
    {
        $user = Auth::user();
        $trip = $this->tripRepo->create([
            'user_id'    => $user->id,
            'title'      => $request->title,
            'time_start' => $request->time_start,
            'time_end'   => $request->time_end
        ]);
        $this->tripUserRepo->createMulti($trip->id, $request->member);
        dd($trip);
    }
}
