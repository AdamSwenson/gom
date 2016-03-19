<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/13/15
 * Time: 10:19 AM
 */

namespace App\Http\Controllers;


use App\Exceptions\SilentlyLoggedException;
use App\HTTP\Controllers\helpers\cleaning\CleanerFactory;
use App\HTTP\Controllers\helpers\cleaning\ICleanerFactory;
use App\Http\Requests\StudentRequest;
use App\Jobs\ImportStudentsFromCsv;
use App\Jobs\AsyncStorage\UpdateStoredExamStats;
use App\Kumi;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use \App\Repositories\Question\IQuestionRepository;
use App\Student;
use App\Exam;
use Illuminate\Http\Request;
use App\Repositories\Student\IKumiRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

/**
 * This handles requests concerning student management such as adding,
 * removing, and editing rosters.
 *
 * @package App\Http\Controllers
 */
class StudentController extends Controller
{

    /** @var IStudentRepository */
    protected $dao;

    /** @var IKumiRepository */
    protected $kumiRepository;

    /** @var  Exam The exam passed in the request */
    public $exam;

    /** @var \App\Repositories\Question\IQuestionRepository */
    protected $questionDao;

    /** @var \App\Repositories\Question\IQuestionAssignmentRepository */
    protected $questionAssignmentDao;
    

    public function __construct()
    {
        $this->middleware('auth');
        //can't do constructor injection in testing non-route stuff
        $this->dao = app()->make('App\Repositories\Student\IStudentRepository');
        $this->kumiRepository = app()->make('App\Repositories\Student\IKumiRepository');
        $this->questionAssignmentDao = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->questionDao = app()->make('App\Repositories\Question\IQuestionRepository');;
    }

    /**
     * Display a listing of the resource.
     * We'll co-op this to display the roster editing page
     *
     * @param StudentRequest $request
     * @return Response
     */
    public function index(StudentRequest $request)
    {
        return view('setup/edit_roster');
    }


    /**
     * Store a newly created set of students in the database.
     * Handles processing an uploaded csv file
     * Creates or loads a new kumi (class) and associates them.
     *
     * @param Exam $exam
     * @param StudentRequest $request
     * @return Response
     */
    public function store(Exam $exam, StudentRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $kumi = $this->kumiRepository->create($exam->name, $exam->year, $exam);

        $processor = app()->make('App\Jobs\StudentImport\IImportStudentsFromCsv');//new ImportStudentsFromCsv();
        $processedStudents = $processor->handle($request);

        $students = array();

        // Now that students are in the database, make a fake class (kumi) for them to belong to
        // and use that class to associate them with the exam
        if (count($processedStudents) > 0)
        {
            foreach ($processedStudents as $student)
            {
                $newStudent = $this->dao->create_student($student['last_name'], $student['first_name'], $student['student_id'], $student['email']);

                $newStudent->kumis()->attach($kumi);

                array_push($students, $newStudent);
            }
        }

        //asynchronously update the stored list of question counts etc
        $this->dispatch(new UpdateStoredExamStats($exam));

        return view('setup.edit_roster')->with(['exam' => $exam, 'students' => $students]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Exam $exam
     * @param Student $student
     * @param StudentRequest $request
     * @return Response
     */
    public function edit(Exam $exam, Student $student, StudentRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        $this->authorize('access-object', $student);

        $students = array();
        $kumi = $this->kumiRepository->load($exam->name, $exam->year);
        if ($kumi)
        {
            $students = $this->dao->load_students_by_exam($exam->getId());
        }

        return view('setup/edit_roster')->with(['exam' => $exam, 'students' => $students]);
    }

    /**
     * Show the form for importing and editing a student roster
     * @param Exam $exam
     * @param StudentRequest $request
     * @return $this
     */
    public function editAll(Exam $exam, StudentRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $examId = $exam->getId();
        $this->kumiRepository->create($exam->getName(), $exam->getYear(), $exam);
        $students = $this->dao->load_students_by_exam($examId);

        // find out where the 'back' button should navigate. Default is editElements.
        $prevAction = 'editElements';
        $prevActionLabel = 'Edit Elements';
        // if no questions, back button goes to exam
        if (sizeof($this->questionAssignmentDao->load_all_for_exam($examId)) == 0)
        {
            $prevAction = 'editExam';
            $prevActionLabel = 'Edit Exam';
        }

        return view('setup/edit_roster')->with(['exam' => $exam, 'students' => $students,
            'prevAction' => $prevAction, 'prevActionLabel' => $prevActionLabel]);
    }


    /**
     * Add or update student records.
     * This is the main method called by the roster editor
     *
     * @param Exam $exam
     * @param StudentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAll(Exam $exam, StudentRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $this->exam = $exam;
        $examId = $this->exam->getId();

        //Do the recording, deleting, et cetera
        $allStudents = $this->dao->update_all($exam, $request);

        //asynchronously update the stored list of student counts etc
        $this->dispatch(new UpdateStoredExamStats($exam));

        /* Handle redirection depending on whether records were invalid */
        if ( !empty($this->dao->studentValidator->invalidRecords) )
        {
            /* Since we're going back to the original roster editing page, we'll need
             * to tell blade where the 'back' button should navigate. Default is editElements.
             */
            $prevAction = 'editElements';
            $prevActionLabel = 'Edit Elements';
            // if no questions, back button goes to exam
            if (sizeof($this->questionAssignmentDao->load_all_for_exam($examId)) == 0)
            {
                $prevAction = 'editExam';
                $prevActionLabel = 'Edit Exam';
            }

            /*
             * Now we can send the user back whence they came with helpful messages
             * to fix the records which weren't valid
             */
            return view('setup/edit_roster')
                ->withErrors($this->dao->studentValidator->errorMessages)
                ->with(
                    [
                        'exam' => $exam,
                        'students' => $allStudents,
                        'prevAction' => $prevAction,
                        'prevActionLabel' => $prevActionLabel
                    ]);
        }

        /* Yay. No students failed validation.
         * But since we could have got here in various ways, we'll
         * redirect to next task based on the button pressed
         */
        flash()->success(count($this->dao->studentValidator->validRecords) . " students added to exam " . $exam->getName());
        $navigate = $request->input('navigateTo');
        switch ($navigate)
        {
            case ('editExam'):
                return redirect()->action('ExamController@edit', ['examId' => $examId]);
                break;

            case ('editElements'):
                // move back to edit elements for the last question
                // why does this have to be a 4 step process?
                // easiest would be $exam->getQuestions() [ returns array of question objects ]
                $questions = $this->questionAssignmentDao->load_all_for_exam($examId);
                $lastQuestionId = $this->questionAssignmentDao->load($examId, sizeof($questions))->getQuestionId();
                $lastQuestion = $this->questionDao->loadQuestionById($lastQuestionId);
                return redirect()->action('ElementController@editAll', array('examId' => $examId,
                    'question' => $lastQuestion));
                break;

            case ('selectExam'):

            default:
                return redirect()->action('ExamController@index')->with(['exam' => $exam]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Student $student
     * @return Response
     */
    public function destroy(Student $student)
    {
        //Check that user owns the exam
        $this->authorize('destroy-object', $student);

        $result = $this->dao->delete_student_by_object($student);

    }

}


