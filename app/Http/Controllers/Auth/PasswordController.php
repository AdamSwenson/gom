<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/exam';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Validate the request of sending reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateSendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email'], ['email' => "We can't find a user with that e-mail address."]);


    }

//
//    /**
//     * Get the password reset validation messages.
//     *
//     * @return array
//     */
//    protected function getResetValidationMessages()
//    {
//        return [
//            'email' => "We can't find a user with that e-mail address."
//        ];
//    }


}
