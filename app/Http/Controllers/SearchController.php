<?php

namespace App\Http\Controllers;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $userRepo;

    private $postRepo;

    public function __construct(PostRepository $postRepo, UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
    }

    public function searchFriend(Request $request) {
        $authUser = Auth::user();
        $searchText = $request->search_text;
        $usersResult = $this->userRepo->searchUser($searchText, $authUser->id);
        return view('search.friend')
            ->with('users', $usersResult['users'])
            ->with('friends', $usersResult['friends'])
            ->with('users_sent_request', $usersResult['user_sent_request'])
            ->with('users_receive_request', $usersResult['user_receive_request']);

    }

    public function searchPost() {

    }
}
