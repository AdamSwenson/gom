<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:15 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class LandingController extends Controller
{

    public function showLanding()
    {
        return view('index');
    }

    public function showLandingLoggedIn()
    {
        return view('landing');
    }

    public function loggedIn(Request $request)
    {

        $email = $request->get('emails');
        $password = $request->get('password');

        return view("account.home")->with([
            'emails' => $email,
            'password' => $password,
        ]);
    }

    public function accountCreate()
    {
return view('auth.register');
//        return view('account.createAccount');
    }


    public function accountConfirm(){

        return view('account.confirmAccount');
    }

    public function retrievePassword(){
        return view('account.retrievePassword');
    }



    public function sentPassword(){
        return view('account.sent');
    }





}