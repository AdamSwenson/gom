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

    /**
     * Show the frequently asked questions page
     */
    public function showFaq()
    {
        return view('other.help');
    }


    public function showGettingStarted()
    {
        return view('other.help');
    }

    /**
     * Show the tutorials and guides page
     */
    public function showGuides()
    {
        return view('other.help');
    }

    public function showTutorials()
    {
        return view('other.video_tutorials');
    }


}
