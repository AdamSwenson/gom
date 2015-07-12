<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:15 PM
 */

namespace App\Http\Controllers;


class LandingController extends Controller
{

    public function showLanding()
    {
     //   return "landing page";
        return view('landing');
    }

    public function showLandingLoggedIn()
    {
        return view('landing');
    }
}