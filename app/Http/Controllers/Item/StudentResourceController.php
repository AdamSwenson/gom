<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;

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

    public function __construct(
        IStudentRepository $studentDao)
    {

        $this->middleware('auth');
        $this->studentDao = $studentDao;
      }
    /**
     * Returns all students belonging to the user
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::all();
    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $student = new Student();
//        $student
    }

    public function getStudentsForExam(Exam $exam){
    return $exam->students()->all();
//        return Student::where('exam_id', $exam->id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Student::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
