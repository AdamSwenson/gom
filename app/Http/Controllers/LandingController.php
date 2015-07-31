<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:15 PM
 */

namespace App\Http\Controllers;


use Swift_Message;
use Swift_Mime_Message;
use Swift_Mailer;
use Swift_SmtpTransport;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class LandingController extends Controller
{

    public function showLanding()
    {

        return view('landing');
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
        return view('account.create');
    }


    public function accountConfirm(){

        return view('account.confirm');
    }

    public function retrievePassword(){
        return view('account.retrieve');
    }

    public function sendEmail(){

        Mail::send('emails.test',[], function($message){
            $message->to('jerrysmash17@gmail.com','')->subject('Welcome to the Laravel 4 Auth App!');
        });


        return view('account.set');
    }




}