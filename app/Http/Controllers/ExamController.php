<?php

namespace App\Http\Controllers;


use App\classes\ExamClasses\display\PublicNameFormatter;
use App\Exam;
use App\Http\Requests\ExamRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $exams = Exam::all();
//        $exams = \ExamQuery::create()->find();
        return view('/setup/select_exam')->with('exams', $exams);
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
        //TODO: Add view here
        return view('', compact('exam'));
        // Maybe write a view to show an exam without editing?
//        $exam = Exam::findOrFail($id);
    }

    /**
     * Show the form for editing the exam resource.
     *
     * @param Exam $exam
     * @return Response
     */
    public function edit(Exam $exam)
    {
        // do something to get id from DB
//        $exam = \ExamQuery::create()->findById($id);

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
        $exam->delete();

        //Todo: add redirect or view
    }

}
