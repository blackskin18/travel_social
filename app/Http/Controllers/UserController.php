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
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    public function personalPage($id)
    {
        $user = $this->userRepository->find($id);
        $posts = $this->postRepository->with('position')->findWhere(['user_id' => $id]);

        return view('user.personal_page')->with('user', $user)->with('articles', $posts);
    }

    public function displayInfo($id)
    {
        $user = $this->userRepository->find($id);

        return view('user.detail_info')->with('user', $user);
    }

    public function changeAvatar(Request $request)
    {
        $user = Auth::user();

        $photo = $request->file;
        $filename = $photo->store('');
        $photo->move(public_path('asset/images/avatar/'.$user->id), $filename);

        $user->avatar = $filename;
        $user->save();

        return Response(['status' => 'success',
                         'data'=> ['src_avatar'=>'asset/images/avatar/'.$user->id.'/'.$filename]], 200)->header('Content-Type', 'text/plain');;
    }
}
