<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
//    protected $redirectTo = '/home';
    protected $redirectTo = '/exam';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);

        $message = "<p>We'd love to hear what you think about the gradeomatic. Please fill out this short survey: <a href='https://docs.google.com/forms/d/e/1FAIpQLSdJBXiK_lmWtT15BrXLpFBiFR5Qly9ab2bgZoy3Wlpu_qDgtw/viewform'>Survey Link</a></p>";

//        //Push message for login into session
        flash()->info($message)->important();
    }
}
