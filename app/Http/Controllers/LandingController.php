<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:15 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use Illuminate\Http\Request;


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

        return view('account.set');
    }

    public function sendEmailReminder(Request $request, $id)
    {
        $user = "jerrysmash17@gmail.com";

        $data = $request->only('name', 'emails', 'phone');
        $data['messageLines'] = explode("\n", $request->get('message'));

       Mail::send('emails.reminder', $data, function ($m) use ($data) {
           $m->subject('Blog Contact Form: '.$data['name'])
               ->to(config('blog.contact_email'))
               ->replyTo($data['emails']);
        });
    }


}