<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class InfoController
 *
 * Handles requests for information about the gradeomatic, the company, etc
 *
 * @package App\Http\Controllers
 */
class InfoController extends Controller
{

    /**
     * Show the page that gives an overview of the gradeomatic
     */
    public function showAbout()
    {
        return view('other/about');
    }


    /**
     * Directs to the page which gives info about the company
     */
    public function showAboutCompany()
    {}

    /**
     * Show contact information page
     * @return \Illuminate\View\View
     */
    public function showContact()
    {
        return view('other/contact');
    }


    public function showGettingStarted()
    {
        return view('other.help');
    }


    /* ----------------------------------- Instructional views */
    /**
     * Show the frequently asked questions page
     */
    public function showFaq()
    {
        return view('help.faq');
    }

    /**
     * Show the guides page
     */
    public function showInstructions()
    {
        return view('help.instructions');
    }


    public function showTutorials()
    {
        return view('other.video_tutorials');
    }


}
