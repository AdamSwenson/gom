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

class GradeController extends Controller {

    protected $IExamRepository;

    public function __construct(IExamRepository $IExamRepository) {
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
    public function grade(Exam $exam) {
        //return('this is the grading page');
        return View::make('grade.grade_exam', compact('exam') );
    }
}