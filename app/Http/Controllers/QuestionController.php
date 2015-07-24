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
     *
     * @return Response
     */
    public function index()
    {
        return view('setup/edit_question');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
    public function update(Question $question, QuestionRequest $request)
    {
        $question->update($request->all());

        //TODO: Add view here
        return view('', compact('question'));

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
