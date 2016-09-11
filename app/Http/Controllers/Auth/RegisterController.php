<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserSignedUpEvent;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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

        $this->middleware('guest');
        $this->middleware('restrictRegistration');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ];

        $messages = [
            'email.required' => 'Your email is required',
            'email.email' => 'Please enter a valid email address',
        ];

        return Validator::make($data, $rules, $messages);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
                                 'name' => $data['name'],
                                 'email' => $data['email'],
                                 'password' => bcrypt($data['password']),
                             ]);
        //Trigger new registration event
        event( new NewUserSignedUpEvent($user) );

        //return the user so RegistersUsers Trait can continue logging in
        return $user;
    }
}
