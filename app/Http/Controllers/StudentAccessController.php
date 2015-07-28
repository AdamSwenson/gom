<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAccessRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class StudentAccessController
 *
 * This handles the events when a student logs in to see their feedback.
 *
 * It corresponds to the old OutputClasses stuff.
 *
 * @package App\Http\Controllers
 */
class StudentAccessController extends Controller
{
    /**
     * Returns the landing page for student access
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Display the feedback for the student.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(StudentAccessRequest $request)
    {
        //
    }

}
