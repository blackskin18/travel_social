<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\User;

class UserController extends Controller
{
	private $user;

	public function __construct()
	{
		$this->user = Auth::user();
	}

    public function personalPage($id)
    {
    	$user = User::find($id);
    	return view('user.personal_page')->with('user', $user);
    }

    public function displayInfo($id)
    {
    	$user = User::find($id);
    	return view('user.detail_info')->with('user', $user);
    }
}
