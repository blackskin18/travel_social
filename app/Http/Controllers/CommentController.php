<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LRedis;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('socket');
    }

    public function writemessage()
    {
        return view('writemessage');
    }

    public function sendMessage(Request $request){
        $redis = LRedis::connection();
        $redis->publish('message', $request->message);
        return redirect('writemessage');
    }
}
