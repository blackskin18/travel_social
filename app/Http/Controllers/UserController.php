<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;

class UserController extends Controller
{
	private $user;
	protected $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->user = Auth::user();
		$this->userRepository = $userRepository;
	}

    public function personalPage($id)
    {
    	$user = $this->userRepository->find($id);
    	return view('user.personal_page')->with('user', $user);
    }

    public function displayInfo($id)
    {
    	$user = $this->userRepository->find($id);
    	return view('user.detail_info')->with('user', $user);
    }
}
