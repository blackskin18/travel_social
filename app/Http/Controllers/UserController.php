<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;
use App\Repository\PostRepository;

class UserController extends Controller
{
    private $user;
    protected $userRepository;
    protected $postRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;

    }

    public function personalPage($id)
    {
        $user = $this->userRepository->find($id);
        $posts = $this->postRepository->findWhere(['user_id'=> $id]);

        return view('user.personal_page')->with('user', $user)->with('articles', $posts);
    }

    public function displayInfo($id)
    {
        $user = $this->userRepository->find($id);
        return view('user.detail_info')->with('user', $user);
    }
}
