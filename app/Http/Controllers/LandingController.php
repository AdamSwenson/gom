<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:15 PM
 */

namespace App\Http\Controllers;

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

        $email = $request->get('email');
        //return $email;
        return view('account.home')->with('email',$email);
    }

    public function accountCreate()
    {
        return view('account.create');
    }

}