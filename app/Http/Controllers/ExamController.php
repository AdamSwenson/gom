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
use Laracasts\Flash\Flash;

/**
 * ExamController routes requests to appropriate page of the create exam workflow
 *
 */
class ExamController extends Controller
{

    const CLONE_FAIL = "There was a problem cloning the exam. Please try again.";
    const CLONE_SUCCESS = "You successfully cloned the exam.";

    const CREATE_SUCCESS = "You successfully created an exam.";
    const CREATE_FAIL = "There was a problem creating the exam.";

    const DELETE_SUCCESS = 'You have successfully deleted an exam.';
    const DELETE_FAIL = 'There was a problem deleting the exam';

    const UPDATE_SUCCESS = "You successfully updated the exam.";
    const UPDATE_FAIL = "There was a problem updating the exam";

    // $terms defines the various yearly divisions the user can choose from in the create / edit exam pages.
    // I've it defined here, but custom terms could be a modified as a preference later on.
    static public $terms = ['Winter', 'Spring', 'Summer', 'Fall'];

    /**@var IExamRepository */
    protected $examDao;
    /** @var IQuestionAssignmentRepository */
    protected $questionAssignmentDao;
    /** @var IStudentRepository */
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
        foreach ( $exams as $exam )
        {
            $examId = $exam->getId();
            $numberStudents = $storedExamStatsDao->getNumberStudents($exam);
            $numberQuestions = $storedExamStatsDao->getNumberQuestions($exam);
            $numberOfStudents[ $examId ] = $numberStudents;
            $numberOfQuestions[ $examId ] = $numberQuestions;
        }

        return View::make('setup.select_exam', [
            'exams'             => $exams,
            'numberOfStudents'  => $numberOfStudents,
            'numberOfQuestions' => $numberOfQuestions,
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
        $years[] = strval($years[0] + 1);

        //custom terms logic would go here

        return view('setup/create_exam', ['years' => $years, 'terms' => self::$terms]);
    }

    /**
     * Copies the selected exam and returns to select exam page
     * @param Exam $exam
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cloneExam(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        try
        {
            $this->examDao->clone_exam($exam->getId());
            $this->dispatch(new UpdateAllStoredExamStats());
            Flash::success(self::CLONE_SUCCESS . $exam->getName());

            return redirect()->action('ExamController@index');
        } catch ( \Exception $e )
        {
            Flash::error(self::CLONE_FAIL);

            return back();
        }
    }

    /**
     * Store a newly created exam in DB.
     *
     * @param ExamRequest $request
     * @return Response
     */
    public function store(ExamRequest $request)
    {
        try
        {
            $exam = $this->examDao->save_new_exam($request->input('examYear'), $request->input('examTerm'), $request->input('name'));
            $this->dispatch(new UpdateAllStoredExamStats());
            Flash::success(self::CREATE_SUCCESS . $exam->getName());

            return redirect()->route('editAllQuestions', $exam);
        } catch ( \Exception $e )
        {
            Session::error(self::CREATE_FAIL);

            return back();
        }
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
        if ( $exam->getYear() < date('Y') )
        {
            $years[] = $exam->getYear();
            $offset = 1;
        }
        $years[] = date('Y');
        $years[] = strval($years[ $offset ] + 1);

        return view('setup/edit_exam', ['exam' => $exam, 'years' => $years, 'terms' => self::$terms]);
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
        try
        {
            $exam = $this->examDao->update_exam_object($exam, $request->input('examYear'), $request->input('examTerm'), $request->input('name'));
            
            $this->dispatch(new UpdateAllStoredExamStats());
            
            Flash::success(self::UPDATE_SUCCESS . $exam->getName());
            
            $eid = $exam->getId();
            if ( $request->input('nextAction') == 'selectExam' )
            {
                return redirect()->action('ExamController@index');
            } else
            {
                return redirect()->route('editAllQuestions', $eid);
            }
        } catch ( Exception $e )
        {
            Flash::error(self::UPDATE_FAIL);

            return back();
        }
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
        if ( ! empty($result) )
        {
            Flash::success(self::DELETE_SUCCESS);
            
             $this->dispatch(new UpdateAllStoredExamStats());
//            Session::flash(self::SUCCESS_FLASH_NAME, self::DELETE_SUCCESS);
        } else
        {
            Flash::error(self::DELETE_FAIL);
        }

        return ['url_redirect' => 'exam'];
    }

}
