<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\AuthRequest;
use App\User;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /** @var string Path to redirect to upon authentication */
    protected $redirectPath = '/exam';

    /** @var string Redirect on unsuccessful login */
    protected $loginPath = '/auth/login';

    protected $redirectAfterLogout = '/index';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->middleware('restrictRegistration');
    }
//
//    /**
//     * Create new account
//     * @param AuthRequest $request
//     */
//    public function postRegister(AuthRequest $request)
//    {
////        $this->middleware('restrictRegistration');
//        parent::postRegister($request);
//
//    }
//
//    /**
//     * Returns the page where the user can create a new account
//     */
//    public function getRegister()
//    {
//        return view('auth.register');
////        return view('account.createAccount');
//    }
//
//
//    /**
//     * Returns the log in page
//     */
//    public function getLogin()
//    {
//        return view($this->loginPath);
//    }

//    /**
//     * Process the request to log in
//     * @param Request $request
//     */
//    public function postLogin(AuthRequest $request)
//    {
//        $validator = $this->validator($request);
//
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
                                'name' => $data['name'],
                                'email' => $data['email'],
                                'password' => bcrypt($data['password']),
                            ]);
    }
}
