<?php

namespace App\Http\Controllers;

use App\Element;
use App\Http\Requests;
use App\Http\Requests\GradingRequest;

use App\Exam;
use App\Http\Requests\ExamRequest;
use App\Repositories\Exam\IExamRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

/**
 * Class GradeController
 *
 * This handles all operations involved in displaying the grading input page and
 * recording the actual grades as they are assigned.
 *
 * @package App\Http\Controllers
 */
class GradeController extends Controller
{

    protected $IExamRepository;

    public function __construct(IExamRepository $IExamRepository)
    {
        $this->middleware('auth');
        $this->examDao = $IExamRepository;
    }

    /**
     *  Presents a list of exams to grade
     */
    public function index() {
        $exams = $this->examDao->load_all_exams();
        return View::make('grade.grade_select_exam', compact('exams') );
    }

    /**
     * Presents the exam for grading
     * @param Exam $exam
     * @return View
     */
    public function grade(Exam $exam)
    {
        $studentDao = app()->make('App\Repositories\Student\IStudentRepository');
        $students = $studentDao->load_students_by_exam($exam);

        return View::make('grade.grade_exam')->with(['exam' => $exam, 'students' => $students]);
    }

    /**
     * Records scores as well as time and any other information
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function recordScore(Exam $exam, GradingRequest $request)
    {
        $questionScoreDao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
        $elementScoreDao = app()->make('App\Repositories\Score\IElementScoreRepository');
    }


    public function getAutoSID()
    {}

    /**
     * Alters the total number of exams to use in statistics
     */
    public function setTotalExams()
    {}
}