<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param id $exam
     * @return Response
     */
    public function index($exam)
    {
        return ('List of all questions for exam #'.$exam);
    }

    /**
     * Show the form for creating a new resource.
     * @param id $exam
     * @return Response
     */
    public function create($exam)
    {
        // $exam from URL: questions must know which exam to be associated with(?)
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $exam
     * @param  int $question
     * @return Response
     */
    public function show($exam, $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $exam
     * @return Response
     * @internal param int $exam
     */
    public function edit($exam, Request $request)
    {
        //dd($request);
        // default data for dev purposes
        $q1 = [ 'qName' => 'teat name #1',
            'qDesc' => 'description 1 here',
            'qOrder' => 1,
            'qId' => 123 ];

        $q2 = [ 'qName' => 'test name #2',
            'qDesc' => 'description 2 here',
            'qOrder' => 2,
            'qId' => 234 ];

        $questions = [ $q1, $q2 ];

        $examName = 'History 101 Exam 1, Fall 2015';


        return view('setup.edit_question')->with([
                'questions' => $questions,
                'examName'=> $examName,
                'examId' => $exam
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $question
     * @return Response
     */
    public function update($question)
    {
        //
    }

    public function updateAll($exam, Request $request) {
        // this function will take a request and process all the questions therein.
        /* it will:
            -Create a new question if the id is empty
            -update an existing question if the id exists
            -set the order property for each question
            -pass the first questionId and examId to ElementController@
        */
        dd($request);

        $data['examId'] = $exam;
        $data['questionId'] = 1;

        return ('this is the edit element view for question #');
        //return view('setup.edit_element')->with(['data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $question
     * @return Response
     */
    public function destroy($question)
    {
        dd($question);
        return ('You have deleted question #'.$question);
    }
}
