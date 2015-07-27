<?php

namespace App\Http\Controllers;



use App\Exam;
use App\Http\Requests\ExamRequest;
use App\Repositories\Exam\IExamRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $this->examDao = $examDao;
    }

    /**
     * Display all exams for the user.
     *
     * @return Response
     */
    public function index()
    {
        //TODO Remove this once the login system is working
        Auth::loginUsingId(1);
        $exams = $this->examDao->load_all_exams();

        return View::make('setup.select_exam', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create()
    {
        //create new exam

        // probably handle cloning here:
        // If the request includes an examId, send to clone() function
        //$data['examName'] = '';
        return view('setup/create_exam');//->with('exam', $data);
    }

    /**
     * Store a newly created exam in storage.
     *
     * TODO Add error handling
     *
     * @param ExamRequest $request
     * @return Response
     */
    public function store(ExamRequest $request)
    {
        $this->examDao->save_new_exam($request->input('year'), $request->input('term'), $request->input('name'));
        Session::flash(self::SUCCESS_FLASH_NAME, self::CREATE_SUCCESS);
        return view('/setup/create_exam');
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
        // do something to get id from DB
        // pass values into $data for view
        $data['examId'] = $exam;
        $data['examName'] = 'Test Name';
        $data['examTerm'] = 'Fall';
        $data['examYear'] = '2014';

        return view('setup/edit_exam', compact('exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Exam $exam
     * @param ExamRequest $request
     * @return Response
     */
    public function update($exam)
    {
        $exam = $this->examDao->update_exam_object($exam, $request->input('year'), $request->input('term'), $request->input('name'));
        Session::flash(self::SUCCESS_FLASH_NAME, self::UPDATE_SUCCESS);
        return view('setup/edit_exam', compact('exam'));
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
        $result = $this->examDao->delete_exam($exam->getId());
        if (!empty($result))
        {
            Session::flash(self::SUCCESS_FLASH_NAME, self::DELETE_SUCCESS);
        }
        return view('/setup/create_exam');
    }

}
