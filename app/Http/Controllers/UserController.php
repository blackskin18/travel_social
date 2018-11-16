<?php

namespace App\Http\Controllers;

use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use App\UserRepository;

class UserController extends Controller
{
	private $user;
	protected $userRepository;

	public function __construct(UserRepository $repository)
	{
		$this->user = Auth::user();
		$this->userRepository = $repository;
	}

    public function personalPage($id)
    {
    	$user = $this->userRepository->all();
    	dd($user);
    	return view('user.personal_page')->with('user', $user);
    }

    public function displayInfo($id)
    {
    	$user = User::find($id);
    	return view('user.detail_info')->with('user', $user);
    }
}
