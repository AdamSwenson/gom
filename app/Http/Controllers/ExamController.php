<?php

namespace App\Http\Controllers;


use App\classes\ExamClasses\display\PublicNameFormatter;
use App\Exam;
use App\Http\Requests\ExamRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/*
    ExamController routes requests to appropriate page of the create exam workflow
*/

class ExamController extends Controller
{
    /**
     * Display all exams for the user.
     *
     * @return Response
     */
    public function index()
    {
        Auth::loginUsingId(1);
//        return "j";
        $exams = Exam::all();
////        $exams = \ExamQuery::create()->find();
      //  return $exams;
        return view('/setup/select_exam', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //create new exam
        return view('/setup/create_exam');
    }

    /**
     * Store a newly created exam in storage.
     *
     * @param ExamRequest $request
     * @return Response
     */
    public function store(ExamRequest $request)
    {

        Exam::create($request->all());

        //TODO Redirect to view

//        $exam = new Exam();
//        $exam->setYear($year_int);
//        $exam->setTerm($clean_term);
//        $exam->setName($clean_name);
//        $exam->save();
    }

    /**
     * Display the specified resource.
     *
     * @param Exam $exam
     * @return Response
     */
    public function show(Exam $exam)
    {
        // Maybe write a view to show an exam without editing?
    }

    /**
     * Show the form for editing the exam resource.
     *
     * @param Exam $exam
     * @return Response
     */
    public function edit(Exam $exam)
    {

        return view('setup/edit_exam', compact('exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Exam $exam
     * @param ExamRequest $request
     * @return Response
     */
    public function update(Exam $exam, ExamRequest $request)
    {
        $exam->update($request->all());

        //Todo: add redirect or view
    }

    /**
     * Remove the exam from storage.
     *
     * Called by Route::delete('exam/{id}';
     *
     * @param Exam $exam
     * @return Response
     * @throws \Exception
     */
    public function destroy(Exam $exam)
    {
        //
        return ('you have successfully destroyed '.$exam.'. Good work.');
        $exam->delete();

        //Todo: add redirect or view
    }

}
