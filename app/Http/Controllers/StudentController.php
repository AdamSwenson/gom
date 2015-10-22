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

    /** @var ICleanerFactory */
    private $cleaner;

    /**
     * @param IStudentRepository $studentRepository
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IQuestionRepository $questionRepository
     * @param IKumiRepository $kumiRepository
     */
    public function __construct(IStudentRepository $studentRepository, IKumiRepository $kumiRepository,
                                IQuestionAssignmentRepository $questionAssignmentRepository, IQuestionRepository $questionRepository)
    {
        $this->middleware('auth');
        $this->dao = $studentRepository;
        $this->kumiRepository = $kumiRepository;
        $this->questionAssignmentDao = $questionAssignmentRepository;
        $this->questionDao = $questionRepository;

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
     * Show the form for creating a new resource.
     *
     * @param StudentRequest $request
     * @return Response
     */
    public function create(StudentRequest $request)
    {
        abort(403);
    }

    /**
     * Store a newly created set of students in the database.
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

//        $processor = new \App\Http\Controllers\helpers\StudentUpload\StudentCsvProcessor();
//        $file = $request->file('studentsFile');
//        $processor->process_file($file->getRealPath());

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

        $examId = $exam->getId();

        //If we already have a kumi for the exam, load it. Otherwise make one.
        $kumi = $this->kumiRepository->load($exam->getName(), $exam->getYear());
        if (!$kumi)
        {
            $kumi = $this->kumiRepository->create($exam->getName(), $exam->getYear(), $exam);
        }

        //Figure out which records are valid, pushing their row numbers into $this->validRecords and
        //$this->invalidRecords respectively
        $this->validateStudents($request);

        /*
         * Process the request, either creating new students, or updating existing students.
         * This will write the data for all students with every pass, modifying the time updated field,
         * regardless of whether the data has changed.
        */
        $currentStudents = [];

        //Write valid student records to the database
        foreach ($this->validRecords as $i)
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
            $currentStudents[$id] = $student;
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
        if (!empty($this->invalidRecords))
        {
            foreach ($this->invalidRecords as $id)
            {
                if ($id !== 0)
                {
                    try
                    {
                        $student = $this->dao->load_student_by_id($id);
                        $currentStudents[$id] = $student;
                    } catch (\Exception $e)
                    {
                    }
                }
            }
        }

        /* Now we can go through and delete any students
         * who are not on the roster (or who had something invalid passed in)
         */
        $allStudents = $this->dao->load_students_by_exam($examId);
        if (count($allStudents) > 0)
        {
            foreach ($allStudents as $student)
            {
                if (!array_key_exists($student->getId(), $currentStudents))
                {
                    $this->dao->delete_student_by_object($student);
                }
            }
        }

        /*
         * The user is going to be pissed if they have to retype the invalid
         * records. Not to mention the difficulty of figuring out what the problem was
         * if they can't see the original.
         * So, we'll return back the invalid records but add a class so that the
         * client can add styling to make it easier for the user to identify them.
        */
        if ( !empty($this->invalidRecords) )
        {
            foreach ($this->invalidRecords as $i)
            {
                $allStudents[] = [
                    'failed' => 'invalidRecord',
                    'last_name' => $request->input('lastName' . $i),
                    'first_name' => $request->input('firstName' . $i),
                    'email' => $request->input('email' . $i),
                    'student_identifier' => $request->input('studentIdentifier' . $i),
                    'id' => $request->input('id' . $i)
                ];
            }

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
             */
            return view('setup/edit_roster')
                ->withErrors($this->errorMessages)
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

        //TODO Add view
    }
//
//    /**
//     * Return the appropriate view based on the button pressed
//     * @param $request
//     */
//    public function handleNavigation($request)
//    {
//        // move to next task based on button pressed
//        $navigate = $request->input('navigateTo');
//        switch ($navigate)
//        {
//            case ('editExam'):
//                return redirect()->action('ExamController@edit', ['examId' => $examId]);
//                break;
//
//            case ('editElements'):
//                // move back to edit elements for the last question
//                // why does this have to be a 4 step process?
//                // easiest would be $exam->getQuestions() [ returns array of question objects ]
//                $questions = $this->questionAssignmentDao->load_all_for_exam($examId);
//                $lastQuestionId = $this->questionAssignmentDao->load($examId, sizeof($questions))->getQuestionId();
//                $lastQuestion = $this->questionDao->loadQuestionById($lastQuestionId);
//                return redirect()->action('ElementController@editAll', array('examId' => $examId,
//                    'question' => $lastQuestion));
//                break;
//
//            case ('selectExam'):
//            default:
//                return redirect()->action('ExamController@index')->with(['exam' => $exam]);
//        }
//    }


    /**
     * Validates student records in incoming request.
     * If it is valid, adds the row identifier to the $this->validRecords array
     * If not valid, adds the row identifier to the $this->invalidRecords array and
     * adds the applicable error messages to $this->errorMessages.
     * @param Request $request
     */
    public function validateStudents(Request $request)
    {
        //Create a new message bag instance
        //TODO: Load this via ioc or otherwise decouple
        $this->errorMessages = new MessageBag();

        for ($i = 1; $i <= $this->chooseLimit($request); $i++)
        {
            //Prepare the rules and messages for the incoming record
            $rules = $this->makeValidationRules($i);
            $name = $request->input('lastName' . $i) . ', ' . $request->input('firstName' . $i);
            $messages = $this->makeMessages($i, $name);

            //Pull out a record from the incoming request
            $incomingStudent = [];
            $incomingStudent['lastName' . $i] = $request->input('lastName' . $i);
            $incomingStudent['firstName' . $i] = $request->input('firstName' . $i);
            $incomingStudent['email' . $i] = $request->input('email' . $i);
            $incomingStudent['studentIdentifier' . $i] = $request->input('studentIdentifier' . $i);
            $incomingStudent['id' . $i] = $request->input('id' . $i);

            $validator = Validator::make($incomingStudent, $rules, $messages);

            if (!$validator->fails())
            {
                //The record passes validation. Add its order number to the validRecords array
                $this->validRecords[] = $i;
            } else
            {
                /* The record failed validation, so we need to send it back to the user for revision.
                 * We'll do this by storing the row number of the record and the failure message.
                 *
                 * First, we add its order number to the invalidRecords array
                 */
                $this->invalidRecords[] = $i;

                /* The flash messaging system will want a MessageBag object. But each validator instance will have
                 * its own message bag. So we'll pull out each message from the current validator's bag and store it
                 * in the controller's message bag (i.e., $this->errorMessages).
                 */
                $messageBag = $validator->getMessageBag();
                foreach ($messageBag->all() as $key => $value)
                {
                    $this->errorMessages->add($key, $value);
                }
            }
        }
    }

    /**
     * Requests have variable field names (they are a string plus the subtask number). We don't know
     * how many elements there will be for a question. Thus this runs though the request and builds rules with the
     * appropriate field names.
     * @param $i The row number to make the rule for
     * @return array
     */
    protected function makeValidationRules($i)
    {
        $rulesArray = [];
        //lastName field
        $rulesArray['lastName' . $i] = 'min:' . self::LAST_NAME_MIN_LENGTH . '|max:' . self::LAST_NAME_MAX_LENGTH;

        //firstName field
        $rulesArray['firstName' . $i] = 'max:' . self::FIRST_NAME_MAX_LENGTH;

        //studentIdentifier field
        $rulesArray['studentIdentifier' . $i] = 'max:' . self::STUDENT_IDENTIFIER_MAX_LENGTH;

        //email field
        $rulesArray['email' . $i] = 'email';

        return $rulesArray;
    }

    /**
     * Build the messages in case row $i's student record proves invalid
     * @param $i
     * @param $studentName
     * @return array
     */
    protected function makeMessages($i, $studentName)
    {
        $messagesArray = [];

        //firstName field
        $messagesArray['firstName' . $i . '.min'] = "The first name for '$studentName' must be at least :min characters long ";
        $messagesArray['firstName' . $i . '.max'] = "The first name for  '$studentName' must be less than :max characters long ";

        //studentIdentifier field
        $messagesArray['studentIdentifier' . $i . '.max'] = "The student id for '$studentName' must be less than :max characters long";

        //email field
        $messagesArray['email' . $i . '.email'] = "The email address for  '$studentName' was invalid";
        $messagesArray['lastName' . $i . '.min'] = "The last name for  '$studentName'  must be at least :min characters long ";
        $messagesArray['lastName' . $i . '.max'] = "The last name for  '$studentName' must be less than :max characters long ";

        return $messagesArray;
    }

    /**
     * We don't want to just iterate over a count of the incoming request.
     * This helps defend against an attack where someone passes a huge incoming request to
     * eat up system resources.
     *
     * If the number of incoming items is less than the max allowed, iterate through
     * the count of the incoming items. Otherwise limit the iteration to the defined maximum.
     *
     * @param Request $request
     * @return int
     * @internal param int $maxItems The absolute maximum number of allowed items
     */
    protected function chooseLimit(Request $request)
    {
        $incomingCount = count($request->all());
        if ($incomingCount < self::MAX_STUDENTS)
        {
            return $incomingCount;
        }
        //  throw new SilentlyLoggedException($type, " Incoming count was: $incomingCount. Allowed maximum was" . self::MAX_STUDENTS);
        return self::MAX_STUDENTS;
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
