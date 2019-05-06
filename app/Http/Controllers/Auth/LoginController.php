<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repository\UserDeviceRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    private $userDevice;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserDeviceRepository $userDevice)
    {
        $this->middleware('guest')->except('logout');
        $this->userDevice = $userDevice;

    }

    protected function sendLoginResponse(Request $request)
    {
        if($request->device_token) {
            $this->userDevice->firstOrCreate(['user_id' => $this->guard()->user()->id, 'device_token' => $request->device_token]);
        }
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }


    protected function logout(Request $request) {
        $this->userDevice->deleteWhere(['user_id' => $this->guard()->user()->id, 'device_token' => $request->device_token]);
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

}
