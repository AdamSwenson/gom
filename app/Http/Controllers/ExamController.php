<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Http\Requests\ExamRequest;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Student\IStudentRepository;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;

/**
 * ExamController routes requests to appropriate page of the create exam workflow
 *
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
    /** @var IQuestionAssignmentRepository  */
    protected $questionAssignmentDao;
    /** @var IStudentRepository  */
    protected $studentDao;

    public function __construct(
        IExamRepository $examDao,
        IQuestionAssignmentRepository $questionAssignmentRepository,
        IStudentRepository $studentRepository
    )
    {
        $this->middleware('auth');
        $this->examDao = $examDao;
        $this->questionAssignmentDao = $questionAssignmentRepository;
        $this->studentDao = $studentRepository;
    }

    /**
     * Display all exams for the user.
     *
     * @return Response
     */
    public function index()
    {
       // $this->dispatch(new UpdateAllStoredExamStats());

        $storedExamStatsDao = app()->make('App\Repositories\Exam\IStoredExamStatsRepository');

        $exams = $this->examDao->load_all_exams();
        $numberOfStudents = [];
        $numberOfQuestions = [];
        foreach($exams as $exam) {
            $examId = $exam->getId();
            $numberStudents = $storedExamStatsDao->getNumberStudents($exam);
            $numberQuestions = $storedExamStatsDao->getNumberQuestions($exam);
            $numberOfStudents[$examId] = $numberStudents;
            $numberOfQuestions[$examId] = $numberQuestions;
        }

        return View::make('setup.select_exam', [
            'exams' => $exams,
            'numberOfStudents' => $numberOfStudents,
            'numberOfQuestions' => $numberOfQuestions
        ]);
    }

    /**
     * Show the form for creating a new exam.
     *
     * @return Response
     */
    public function create()
    {
        //create new exam
        $years[] = date('Y');
        $years[] = strval( $years[0] + 1 );

        // $terms defines the various yearly divisions the user can choose from in the create / edit exam pages.
        // I've it defined here, but custom terms could be a modified as a preference later on.
        $terms = [ 'Winter', 'Spring', 'Summer', 'Fall'];
        return view('setup/create_exam', [ 'years' => $years, 'terms' => $terms ]);
    }

    /**
     * Copies the selected exam and returns to select exam page
     * @param Exam $exam
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cloneExam(Exam $exam) {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $this->examDao->clone_exam($exam->getId());

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
     * Show the form for editing the exam resource.
     *
     * @param Exam $exam
     * @return Response
     */
    public function edit(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('alter-object', $exam);

        // create a list of years to choose from. Includes the year of the exam, plus this year and the next year.
        $offset = 0;
        if ( $exam->getYear() < date('Y') ) {
            $years[] = $exam->getYear();
            $offset = 1;
        }
        $years[] = date('Y');
        $years[] = strval( $years[$offset] + 1 );

        $terms = [ 'Winter', 'Spring', 'Summer', 'Fall'];
        return view('setup/edit_exam', [ 'exam' => $exam, 'years' => $years, 'terms' => $terms ]);
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
        //Check that user owns the exam
        $this->authorize('alter-object', $exam);

        $exam = $this->examDao->update_exam_object($exam, $request->input('examYear'), $request->input('examTerm'), $request->input('name'));

        Session::flash(self::SUCCESS_FLASH_NAME, self::UPDATE_SUCCESS);
        $eid = $exam->getId();
        if ($request->input('nextAction') == 'selectExam') {
            return redirect()->action('ExamController@index');
        }
        else
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
        //Check that user owns the exam
        $this->authorize('destroy-object', $exam);

        $result = $this->examDao->delete_exam($exam);
        if (!empty($result))
        {
            Session::flash(self::SUCCESS_FLASH_NAME, self::DELETE_SUCCESS);
        }

        return [ 'url_redirect' => 'exam' ] ;
    }

}
