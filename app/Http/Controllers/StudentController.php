<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/13/15
 * Time: 10:19 AM
 */

namespace App\Http\Controllers;


use App\classes\ExamClasses\service\CurrentExamManager;
use App\classes\ImportExportClasses\StudentUpload\StudentCsvProcessor;
use App\classes\ImportExportClasses\dao\Uploader;
use App\classes\RequestClasses\FileRequest;
use App\Http\Controllers\helpers\ExamSelectorHelper;
use App\Http\Requests\StudentRequest;
use App\Repositories\Student\IStudentRepository;
use App\Student;

class StudentController extends Controller
{
    /** @var IStudentRepository  */
    protected $dao;

    public function __construct(IStudentRepository $studentRepository)
    {
        $this->dao = $studentRepository;
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
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     * @return Response
     */
    public function store(StudentRequest $request)
    {
        $student = $this->dao->create_student($request->input('lastName'), $request->input('firstName'), $request->input('studentId'), $request->input('email'));
        //todo add view to return
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
     * @param Student $student
     * @param StudentRequest $request
     * @return Response
     *
     */
    public function edit(Student $student, StudentRequest $request)
    {
        //
    }

    /**
     * Show the form for importing and editing a student roster
     */
    public function editAll($exam, StudentRequest $request) {
        return view('setup/edit_roster');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Student $student, StudentRequest $request)
    {
        //
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
}