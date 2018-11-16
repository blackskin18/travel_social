<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest;

use App\Model\User;

class PostController extends Controller
{
	private $user;

	public function __construct()
	{
		$this->user = Auth::user();
	}

    public function create(CreatePostRequest $request)
    {
        $post = new Post();
        $post->user_id = 1;
        $post->description = "1";
        $post->status = 1;
        $post->type = 1;
        $post->save();
    }
}
