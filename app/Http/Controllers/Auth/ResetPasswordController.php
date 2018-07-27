<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Codeception\Module\REST;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Class ResetPasswordController
 * This handles the actual resetting of the password. It does not handle
 * sending the reset email or showing the initial reset form in which
 * the user enters their email. Those functions are handled by
 * ForgotPasswordController
 *
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller
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

    protected $redirectTo = 'dev/setup';

    //old version
//    protected $redirectTo = '/exam';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validate the request of sending reset link.
     * This replaces the validation method in the laravel package trait.
     * If composer updates that trait, this may stop working.
     * If that's the case, we just need to add a validateSendResetLinkEmail method
     * to the trait which contains the package logic. That way, this will override it
     * @param Request $request
     */
    public function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email'], ['email' => "We can't find a user with that e-mail address."]);
    }

}


