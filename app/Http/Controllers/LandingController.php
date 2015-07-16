<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:15 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;

class LandingController extends Controller
{

    public function showLanding()
    {
       // Schema::create('art',function($newtable)
      //  {
      //      $newtable -> increments('id');
      //      $newtable -> string('artist');
      //      $newtable -> string('title',500);
      //      $newtable -> text('description');
     //   });
        return view('landing');
    }

    public function showLandingLoggedIn()
    {
        return view('landing');
    }
}