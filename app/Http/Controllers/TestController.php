<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Used in unit testing of javascript.
 * Must be running in codeceptWorld otherwise will send back
 * @package App\Http\Controllers
 */
class TestController extends Controller
{
    
    public function __construct()
    {
        if ( env('APP_ENV')!= 'codeceptWorld' )
        {
            return back();
        }
    }
    
    
    public function gradingSlidersTest(){
        return view('tests.grade.gradingSlidersTest');
    }

    public function newGrading(){
        return view('development.newGrading');
    }

    public function test()
    {
        return view('development.test');

    }

}
