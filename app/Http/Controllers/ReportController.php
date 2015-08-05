<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 11:22 AM
 */

namespace App\Http\Controllers;

use App\Events\ExamReleasedEvent;
use App\Exam;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * @var IStudentRepository
     */
    private $studentRepository;
    protected $examDao;

    /**
     * @param IExamRepository $examRepository
     * @param IStudentRepository $studentRepository
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IElementAssignmentRepository $elementAssignmentRepository
     * @param IQuestionScoreRepository $questionScoreRepository
     * @param IElementScoreRepository $elementScoreRepository
     * @param ICommentRepository $commentRepository
     * @param IStudentRepository $studentRepository
     */
    public function __construct(
        IExamRepository $examRepository,
        IStudentRepository $studentRepository,
        IQuestionAssignmentRepository $questionAssignmentRepository,
        IElementAssignmentRepository $elementAssignmentRepository,
        IQuestionScoreRepository $questionScoreRepository,
        IElementScoreRepository $elementScoreRepository,
        ICommentRepository $commentRepository,
    IStudentRepository $studentRepository
    ) {
        //TODO Remove this once the login system is working
        Auth::loginUsingId(1);
        $this->examDao = $examRepository;
        $this->questionAssignmentRepository = $questionAssignmentRepository;
        $this->elementAssignmentRepository = $elementAssignmentRepository;
        $this->questionScoreRepository = $questionScoreRepository;
        $this->elementScoreRepository = $elementScoreRepository;
        $this->commentRepository = $commentRepository;
        $this->studentRepository = $studentRepository;
    }


    public function showGradeAssign(){
        return "Grade assignment page here";
    }

    /**
     * Receives the command to create feedback for the exam and dispatches the
     * events to take care of it
     * @param Exam $exam
     * @return \Illuminate\View\View
     */
    public function createFeedback(Exam $exam)
    {
        event(new ExamReleasedEvent($exam));
        return view('feedback.progress_compiling');
//
//        $feedbackBuilder = new FeedbackBuilder();
//
//        $feedback = $feedbackBuilder->buildFeedback($exam->getId());
//        $accessKeys = array_keys($feedback);
////        dd($feedback[5]);
//        $data = $feedback[$accessKeys[0]];

     //   return view('feedback.feedback', compact('data'));
    }

    public function showExams()
    {
        $exams = $this->examDao->load_all_exams();
        //$students = $this->studentDao->load_all_students();
        return view('reports.ExamsRelease', compact('exams'));
    }

    public function showStudents(Exam $exam){
        $students = $this->studentRepository->load_students_by_exam($exam->getId());
        return view('reports.studentsGrades')->with(['exam' => $exam,'students'=>$students]);
    }

    public function showAnalytics(Exam $exam){
        $students = $this->studentRepository->load_students_by_exam($exam->getId());
        return view('reports.analyticsCharts')->with(['exam' => $exam,'students'=>$students]);
    }

}