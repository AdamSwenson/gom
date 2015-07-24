<?php

namespace App\Http\Controllers;


use App\classes\ExamClasses\display\PublicNameFormatter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
    ExamController routes requests to appropriate page of the create exam workflow
*/

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index() {
        $exams['exam1'] = [ 'examName' => 'History 101 Exam #1 Fall 2015',
            'examId' => '1'];
        $exams['exam2'] = [ 'examName' => 'History 101 Exam #2 Fall 2015',
            'examId' => '2'];

        //dd($exams);
        return view('/setup/select_exam')->with(['exams' => $exams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        //create new exam

        // probably handle cloning here:
        // If the request includes an examId, send to clone() function
        //$data['examName'] = '';
        return view('setup/create_exam');//->with('exam', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // save the exam and redirect to QuestionController
        return ('this is the exam store page');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $exam
     * @return Response
     */
    public function show($exam)
    {
        //

        return ('ExamController@show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $exam
     * @param Request $request
     * @return Response
     */
    public function edit($exam, Request $request)
    {
        // do something to get id from DB

        $data['examId'] = $exam;
        $data['examName'] = 'Test Name';

        //$examId = $request->get('examId');
        //dd($request);
        return view('setup/edit_exam')->with('exam', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $exam
     * @return Response
     */
    public function update($exam)
    {
        //update given exam in DB
        return ('you have upadted exam #'.$exam);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $exam
     * @return Response
     */
    public function destroy($exam)
    {
        //
        return ('you have successfully destroyed '.$exam.'. Good work.');
    }

}
