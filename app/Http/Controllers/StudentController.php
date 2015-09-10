<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/13/15
 * Time: 10:19 AM
 */

namespace App\Http\Controllers;


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

/**
 * Class StudentController
 *
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
        //
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

        //todo add view for model bound
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
        $examId = $exam->getId();
        $this->kumiRepository->create($exam->getName(), $exam->getYear(), $exam);
        $students = $this->dao->load_students_by_exam($examId);

        // find out where the 'back' button should navigate. Default is editElements.
        $prevAction = 'editElements';
        $prevActionLabel = 'Edit Elements';
        // if no questions, back button goes to exam
        if ( sizeof($this->questionAssignmentDao->load_all_for_exam($examId)) == 0 ) {
            $prevAction = 'editExam';
            $prevActionLabel = 'Edit Exam';
        }

        return view('setup/edit_roster')->with(['exam' => $exam, 'students' => $students,
            'prevAction' => $prevAction, 'prevActionLabel' => $prevActionLabel ]);
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
        //
    }

    public function updateAll(Exam $exam, StudentRequest $request)
    {
        // TODO: validate that first and last names are non-empty
        $examId = $exam->getId();
        $kumi = $this->kumiRepository->load($exam->getName(), $exam->getYear());
        if (!$kumi) {
            $kumi = $this->kumiRepository->create($exam->getName(), $exam->getYear(), $exam);
        }

        // process the request, either creating new students, or updating existing students.
        // this will write the data for all students with every pass, modifying the time updated field,
        // regardless of whether the data has changed.
        $currentStudents = [];
        $i = 1;
        while( $request->input('lastName'.$i) ) {
            $lName = $request->input('lastName'.$i);
            $fName = $request->input('firstName'.$i);
            $email = $request->input('email'.$i);
            $identifier = $request->input('studentIdentifier'.$i);
            $id = $request->input('id'.$i);
            $student = null;
            if ($id == 0) {
                // create new student
                $student = $this->dao->create_student($lName, $fName, $identifier, $email);
                $id = $student->getId();
                $student->kumis()->attach($kumi); // add the student to the kumi
            } else {
                // why do we need to call save for some classes and not others?
                $student = $this->dao->load_student_by_id($id);
                $student->setStudentFName($fName);
                $student->setStudentLName($lName);
                $student->setStudentId($identifier);
                $student->setEmail($email);
                $student->save();
            }
            $currentStudents[$id] = $student;
            $i++;
        }

        // delete any students not on this roster
        $allStudents = $this->dao->load_students_by_exam($examId);
        if ( count($allStudents) > 0 ) {
            foreach ($allStudents as $student) {
                if ( !array_key_exists($student->getId(), $currentStudents) ) {
                    $this->dao->delete_student_by_object($student);
                }
            }
        }

        // move to next task based on button pressed
        $navigate = $request->input('navigateTo');
        switch ($navigate) {
            case ('editExam'):
                return redirect()->action('ExamController@edit', [ 'examId' => $examId ]);
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
        $result = $this->dao->delete_student_by_object($student);

        //TODO Add view
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
