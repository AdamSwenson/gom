<?php

namespace App\Http\Controllers;



use App\Exam;
use App\Http\Requests\ExamRequest;
use App\Repositories\Exam\IExamRepository;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

/*
    ExamController routes requests to appropriate page of the create exam workflow
*/

class ExamController extends Controller
{
    const SUCCESS_FLASH_NAME = "flash_message_success";
    const FAIL_FLASH_NAME = "flash_message_fail";

    const CREATE_SUCCESS = "Successfully created exam";
    const CREATE_FAIL = "There was a problem creating the exam";

    const UPDATE_SUCCESS = "Successfully updated the exam";
    const UPDATE_FAIL = "There was a problem updating the exam";

    const DELETE_SUCCESS = 'you have successfully destroyed an exam. I hope you are proud of yourself.';
    const DELETE_FAIL = 'There was a problem deleting the exam';

    /**@var IExamRepository */
    protected $examDao;

    public function __construct(IExamRepository $examDao)
    {
        $this->middleware('auth');
        $this->examDao = $examDao;
    }

    /**
     * Display all exams for the user.
     *
     * @return Response
     */
    public function index()
    {
        $exams = $this->examDao->load_all_exams();
        return View::make('setup.select_exam', compact('exams'));
    }

    /**
     * Show the form for creating a new exam.
     *
     * @return Response
     */
    public function create()
    {
        //create new exam
        return view('setup/create_exam');
    }

    // copies the selected exam and returns to select exam page
    public function cloneExam(Exam $exam) {

        // TODO: clone the thing here!

        return redirect()->action('ExamController@index');
    }

    /**
     * Store a newly created exam in DB.
     *
     * TODO Add error handling
     *
     * @param ExamRequest $request
     * @return Response
     */
    public function store(ExamRequest $request)
    {
        $exam = $this->examDao->save_new_exam($request->input('examYear'), $request->input('examTerm'), $request->input('name'));
        Session::flash(self::SUCCESS_FLASH_NAME, self::CREATE_SUCCESS);
        return redirect()->route('editAllQuestions', $exam);
    }

    /**
     * Display given exam.
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
        $exam = $this->examDao->update_exam_object($exam, $request->input('examYear'), $request->input('examTerm'), $request->input('name'));

        Session::flash(self::SUCCESS_FLASH_NAME, self::UPDATE_SUCCESS);
        $eid = $exam->getId();
        return redirect()->route('editAllQuestions', $eid);
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
        $result = $this->examDao->delete_exam_object($exam);
        if (!empty($result))
        {
            Session::flash(self::SUCCESS_FLASH_NAME, self::DELETE_SUCCESS);
        }
        return redirect()->action('ExamController@index');
    }

}
