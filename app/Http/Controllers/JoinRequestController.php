<?php

namespace App\Http\Controllers;

use App\Repository\JoinRequestRepository;
use Illuminate\Http\Request;

class JoinRequestController extends Controller
{
    //
    protected $joinRequestRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JoinRequestRepository $joinRequestRepository
    ) {
        $this->middleware('auth');
        $this->joinRequestRepo = $joinRequestRepository;
    }
}
