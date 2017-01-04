<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * Class ForgotPasswordController
 * This handles showing the form to request a password reset and the
 * logic for sending the email.
 *
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails{
        sendResetLinkEmail as trait_sendResetLinkEmail;
    }

    /**
     * Create a new controller instance.
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
        $this->validate($request, ['email' => 'required|email'], ['validation.email' => "We can't find a user with that e-mail address."]);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email'], ['email' => "We can't find a user with that e-mail address."]);
        return $this->trait_sendResetLinkEmail($request);
    }
}
