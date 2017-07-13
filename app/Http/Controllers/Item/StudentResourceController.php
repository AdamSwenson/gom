<?php

namespace App\Http\Controllers\Item;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Repositories\Student\IStudentRepository;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * Class StudentResourceController
 *
 * This covers student related stuff in the
 * new setup
 * @package App\Http\Controllers\Item
 */
class StudentResourceController extends Controller
{

    /** @var IStudentRepository */
    protected $studentDao;

    public static $fields = ['firstName', 'lastName', 'studentIdentifier', 'id', 'email'];

    /**
     * The client sends all fields camel cased
     * but the Student attributes are snake cased.
     * This builds an array from the request to be used in create and
     * update methods on Student
     *
     * @param StudentRequest $request
     * @return array
     */
    public static function convertIncoming(StudentRequest $request){
        $out = [];
        foreach (self::$fields as $f){
            //we don't want it to try to set id from the incoming
            if( $request->has($f))
            {
//            if($f !== 'id'){ // || $request->has('id')
                $out[snake_case($f)] = $request->input($f);
            }
        }
        return $out;
    }

    /**
     * The client expects all fields to be camel cased
     * but the Student attributes are snake cased.
     * This builds an array to return to the client from a student
     * @param Student $student
     * @return array
     */
    public static function convertOutgoing(Student $student){
        $out = [];
        foreach (self::$fields as $f){ //$f is the camel cased version used by the client
          //  $s = snake_case($f);
            $out[ $f ] = $student->$f; //so we get the snake cased property
        }
        return $out;
    }

    public function __construct(
        IStudentRepository $studentDao )
    {

        $this->middleware('auth');
        $this->studentDao = $studentDao;
    }


    /**
     * Returns all students belonging to the user.
     *
     * Called on client by loadAllStudents without an exam param
     *
     * Route:
     *      GET
     *      'dev/students'
     *
     * @return Response
     */
    public function index()
    {
        $out = [];
        $students = Student::all();
        foreach ($students as $student){
            $out[] = self::convertOutgoing($student);
        }
        return $out;
    }

    /**
     * Creates a student with the given properties in the database.
     * Does not associate the student with a class or exam.
     *
     * Called on the client by:
     *      createStudent: (store, student) =>{},
     *
     * Route:
     *      POST
     *
     * @param StudentRequest $request
     * @return Response
     */
    public function store( StudentRequest $request )
    {
        $incoming = self::convertIncoming($request);
        $student = Student::create($incoming);
        $c = self::convertOutgoing($student);
        return $c;
    }


    /**
     * Display the specified student.
     *
     * Called on the client by
     *      loadStudent: (store, student) =>{},
     *
     * Route:
     *      GET
     *      dev/students/{student}
     *
     * @param $id
     * @return Response
     * @internal param Student $student
     */
    public function show( $id )
    {
        $student = Student::find($id);
        return self::convertOutgoing($student);
    }


    /**
     * Update intrinsic properties of an existing student.
     * This does not affect their associations with a class or exam.
     *
     * Called on the client by:
     *      updateStudent: (store, student) => {},
     *
     * Route
     *      PUT|PATCH
     *      dev/students/{student}
     *
     * @param Student $student
     * @param StudentRequest|Request $request
     * @return Response
     * @throws \Exception
     */
    public function update( Student $student, StudentRequest $request )
    {
        try {
            $incoming = self::convertIncoming($request);
            $student->update($incoming);
            $this->sendAjaxSuccess();
        } catch (Exception $e) {
            $this->sendAjaxFailure();
            throw $e;
        }
    }

    /**
     * Requests the permanent removal of all data about the student
     * Called on the client by:
     *         destroyStudent: (store, student) =>{
     * Route
     *      DELETE
     *      dev/students/{id}
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function destroy( $id )
    {
        try{
            $student = Student::find($id);
            $student->delete();
            $this->sendAjaxSuccess();
        } catch (Exception $e) {
            $this->sendAjaxFailure();
            throw $e;
        }
    }
}
