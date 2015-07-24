<?php

namespace App\Http\Controllers;

use App\classes\RequestHandlers\workers\QuestionWorker;
use App\Http\Requests\QuestionRequest;
use App\Question;
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
    public function store(QuestionRequest $request)
    {
        $worker = new QuestionWorker();
        $question = $worker->createQuestion($request['questionName'], $request['questionDesc'], $request['order'], $request['examId']);

        //TODO: Add view here
        return view('', compact('question'));

    }

    /**
     * Display the specified question.
     *
     * The model is bound to the route so the id does not
     * need to be specified as an argument here (though it still
     * needs to be in the route).
     *
     * @param Question $question
     * @return Response
     */
    public function show(Question $question)
    {

        //TODO: Add view here
        return view('', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     *
     * @param Question $question
     * @return Response
     */
    public function edit(Question $question)
    {
        //dd($request);
        // default data for dev purposes
        $q1 = [ 'qName' => 'teat name #1',
            'qDesc' => 'description 1 here',
            'qOrder' => 1];

        $q2 = [ 'qName' => 'test name #2',
            'qDesc' => 'description 2 here',
            'qOrder' => 2];

        $questions = [ $q1, $q2 ];

        $examName = 'History 101 Exam 1, Fall 2015';

        //return view('/setup/edit_question');
        return view('setup.edit_question')->with([
                'questions' => $questions,
                'examName'=> $examName,
                'examId' => $exam
        ]);
        //TODO: Add view here
        return view('', compact('question'));
    }

    /**
     * Update the specified question in storage.
     *
     * @param Question $question
     * @param QuestionRequest $request
     * @return Response
     */
    public function update($id)
    {
        $question->update($request->all());

        //TODO: Add view here
        return view('', compact('question'));

    }

    public function updateAll($exam) {
        // this function will take a request and process all the questions therein.
        /* it will:
            -Create a new question if the id is empty
            -update an existing question if the id exists
            -set the order property for each question
            -pass the first questionId and examId to ElementController@
        */
        $data['examId'] = $exam;
        $data['questionId'] = 1;
        return view('setup.edit_element')->with(['data' => $data]);
    }

    /**
     * Remove the specified question from storage.
     *
     * @param Question $question
     * @return Response
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();
        //TODO: Add view here
        return view('', compact('question'));

    }
}
