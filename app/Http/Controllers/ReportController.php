<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 11:22 AM
 */

namespace App\Http\Controllers;

use App\Exam;
use App\Http\Requests\ExamRequest;
use App\Repositories\Exam\IExamRepository;
use App\Http\Requests\StudentRequest;
use App\Repositories\Student\IStudentRepository;

class ReportController extends Controller
{
    protected $examDao;
    protected $studentDao;

    public function __construct(IStudentRepository $studentRepository,IExamRepository $examDao)
    {
        $this->examDao = $examDao;
        $this->studentDao = $studentRepository;
    }

    public function showExams()
    {
        //TODO Remove this once the login system is working

        $exams = $this->examDao->load_all_exams();
        //$students = $this->studentDao->load_all_students();

        return view('reports.examsRelease', compact('exams'));

    }

    public function showStudents(Exam $exam){
        $students = $this->studentDao->load_students_by_exam($exam->getId());

        return view('reports.studentsGrades')->with(['exam' => $exam,'students'=>$students]);
    }

    public function showAnalytics(Exam $exam){
         $students = $this->studentDao->load_students_by_exam($exam->getId());

        return view('reports.analyticsCharts')->with(['exam' => $exam,'students'=>$students]);
    }

    public function showGradeAssign(){
        return "Grade assignment page here";
    }
}