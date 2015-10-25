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

    const LAST_NAME_MIN_LENGTH = 2;

    const LAST_NAME_MAX_LENGTH = 255;

    const FIRST_NAME_MIN_LENGTH = 2;

    const FIRST_NAME_MAX_LENGTH = 255;

    const STUDENT_IDENTIFIER_MAX_LENGTH = 225;

    /** Absolute max number of students that can be added in a request (to help prevent attacks with large numbers) */
    const MAX_STUDENTS = 1000;

    /** @var array When a request to alter students comes in, this holds records which pass validation */
    protected $validRecords = [];

    /** @var array When a request to alter students comes in, this holds records which fail validation */
    protected $invalidRecords = [];

    /** @var array Error messages to return to the user */
    protected $errorMessages;

    /** @var IStudentRepository */
    protected $dao;
    /** @var IKumiRepository */
    protected $kumiRepository;

    /** @var  IStudentValidator */
    public $studentValidator;

    /** @var array Holds the students that are present in the current request */
    protected $currentStudents = [];

    /** @var  Exam The exam passed in the request */
    public $exam;
    protected $allStudents;

    /** @var ICleanerFactory */
    private $cleaner;


    public function __construct()
//IStudentRepository $studentRepository,
//                                IKumiRepository $kumiRepository,
//                                IQuestionAssignmentRepository $questionAssignmentRepository,
//                                IQuestionRepository $questionRepository)
    {
        $this->middleware('auth');
        //can't do constructor injection in testing non-route stuff
//        app()->make('App\Repositories\Student\IStudentRepository');
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

        $allStudents = $this->dao->update_all($exam, $request);

//        //If we already have a kumi for the exam, load it. Otherwise make one.
//        $kumi = $this->kumiRepository->load($this->exam->getName(), $this->exam->getYear());
//        if (!$kumi)
//        {
//            $kumi = $this->kumiRepository->create($this->exam->getName(), $this->exam->getYear(), $this->exam);
//        }
//
//        /*
//         * Figure out which records are valid, pushing their row numbers into $this->studentValidator->validRecords
//         * and $this->studentValidator->invalidRecords respectively
//         */
//        $this->studentValidator = app()->make('App\Http\Controllers\helpers\validation\IStudentRecordValidator');
//        $this->studentValidator->validateStudents($request);
//
//        /* Update the database */
//        $this->updateStudentsInDatabase($request, $kumi);
//
//        /*
//         * The user is going to be pissed if they have to retype the invalid
//         * records. Not to mention the difficulty of figuring out what the problem was
//         * if they can't see the original.
//         * So, we'll return back the invalid records but add a class so that the
//         * client can add styling to make it easier for the user to identify them.
//        */
//        if ( !empty($this->studentValidator->invalidRecords) )
//        {
//            foreach ($this->studentValidator->invalidRecords as $i)
//            {
//                $this->allStudents[] = [
//                    'failed' => 'invalidRecord',
//                    'last_name' => $request->input('lastName' . $i),
//                    'first_name' => $request->input('firstName' . $i),
//                    'email' => $request->input('email' . $i),
//                    'student_identifier' => $request->input('studentIdentifier' . $i),
//                    'id' => $request->input('id' . $i)
//                ];
//            }

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
     * This handles all the database operations for updating students.
     * It creates or updates all valid records from $request (the validator needs to have
     * been called previously) and deletes records from the database that were not
     * in the incoming request (which includes both valid and invalid records).
     *
     * This will write the data for all students with every pass, modifying the time updated field,
     * regardless of whether the data has changed.
     *
     * It also updates the $this->currentStudents array in preparation for deleting
     *
     * @param $request
     * @param $kumi
     */
    public function updateStudentsInDatabase(Request $request, $kumi)
    {

        //Write valid student records to the database and store them in $this->currentStudents
        foreach ($this->studentValidator->validRecords as $i)
        {
            $lName = $request->input('lastName' . $i);
            $fName = $request->input('firstName' . $i);
            $email = $request->input('email' . $i);
            $identifier = $request->input('studentIdentifier' . $i);
            $id = $request->input('id' . $i);
            $student = null;
            if ($id == 0)
            {
                // create new student
                $student = $this->dao->create_student($lName, $fName, $identifier, $email);
                $id = $student->getId();
                $student->kumis()->attach($kumi); // add the student to the kumi
            } else
            {
                // why do we need to call save for some classes and not others?
                $student = $this->dao->load_student_by_id($id);
                $student->setStudentFName($fName);
                $student->setStudentLName($lName);
                $student->setStudentId($identifier);
                $student->setEmail($email);
                $student->save();
            }
            $this->currentStudents[$id] = $student;
        }

        // TODO: Add test to ensure that does not delete any pre-existing students which might have been altered to make invalid, lest we destroy their exam scores

        /*
         * Next, we need to delete any students from the database whom the user
         * deleted.
         * But we need to be careful. If there were invalid records in the request,
         * the user might not have intended to delete the student. For example, they
         * may have gone back to add an email address after grading a student's exam
         * and mistyped the email address. If we we're just to delete everything not in
         * the validStudents array, all the work of grading the student would be lost.
         *
         * So, first, we will try loading students with invalid records. Note that we don't
         * care if the id can't be found in the db. Nor do we care if they were a new record
         * (since they wouldn't be in the db and the row will be passed back to the user later).
         */
        if (!empty($this->studentValidator->invalidRecords))
        {
            foreach ($this->studentValidator->invalidRecords as $id)
            {
                if ($id !== 0)
                {
                    try
                    {
                        $student = $this->dao->load_student_by_id($id);
                        $this->currentStudents[$id] = $student;
                    } catch (\Exception $e)
                    {
                    }
                }
            }
        }

        /* Now we can go through and delete any students
         * who are not on the roster
         */
        $this->allStudents = $this->dao->load_students_by_exam($this->exam->getId());
        if (count($this->allStudents) > 0)
        {
            foreach ($this->allStudents as $student)
            {
                if (!array_key_exists($student->getId(), $this->currentStudents))
                {
                    $this->dao->delete_student_by_object($student);
                }
            }
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

        //TODO Add view
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Student $student
     * @param StudentRequest $request
     * @return Response
     */
    public function update(Student $student, StudentRequest $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return Response
     */
    public function show(Student $student)
    {
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param StudentRequest $request
     * @return Response
     */
    public function create(StudentRequest $request)
    {
        abort(403);
    }
}



//    public function processStudentFile()
//    {

//        /** @var $files Array of raw files passed in */
//        public $files = array();
//
//        /** @var $filenames Array holding names of files passed in */
//        public $filenames = array();
//
//
//    /**
//     * Captures any files that came in with the request
//     */
//    public function load_files() {
//        if (isset($_FILES) && (count($_FILES) > 0) && ($_FILES["file"]["size"] > 0)) {
//            if (count($_FILES) === 1) {
//                array_push($this->filenames, $_FILES["file"]["tmp_name"]);
//                $this->files = $_FILES;
//            } else {
//                //add handling if this is ever an issue
//                throw new \Exception('unexpected number of files passed in');
//            }
//        }
//    }

//    }


/* commenting the old StudentController out for reference
{
    public $exam;

    public $examSelectorHelper;

    public function __construct()
    {
        $current_exam_manager = new CurrentExamManager();
        $this->exam = $current_exam_manager->get_current_exam();
        $this->examSelectorHelper = new ExamSelectorHelper();
    }


    public function showStudentUploader()
    {
        $out = [
            'pageTitle' => 'Manage students',
            "inPageTitle" => "Upload student information",
        ];

        return view('setup/student_manage', $this->examSelectorHelper->makeExamSelectorComponent($out));
    }

    public function handleUpload()
    {

        $request = FileRequest::create();

        $status = 'unloaded';
        if($this->exam && ($request->task() === 'uploadStudents'))
        {
            $uploader = new Uploader();
            $uploader->set_file_processor(new StudentCsvProcessor());
            $uploader->set_exam($this->exam);
            if($uploader->process($request)){
                $status = 'success';
            }else{
                $status = 'fail';
                $errors = $uploader->errors;
            }
        }
    }

}*/
