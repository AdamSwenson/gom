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
use App\Student;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class ReportController
 *
 * This handles requests having to do with the generation and editing of reports.
 *
 * All operations require the user to be logged in. This does NOT handle student's access to
 * their comments.
 *
 * @package App\Http\Controllers
 */
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
    )
    {
        $this->middleware('auth');
        $this->examDao = $examRepository;
        $this->questionAssignmentRepository = $questionAssignmentRepository;
        $this->elementAssignmentRepository = $elementAssignmentRepository;
        $this->questionScoreRepository = $questionScoreRepository;
        $this->elementScoreRepository = $elementScoreRepository;
        $this->commentRepository = $commentRepository;
        $this->studentRepository = $studentRepository;
    }


    public function showGradeAssign()
    {
        return "Grade assignment page here";
    }


    /**
     * Recompiles the feedback for a particular student.
     *
     * This is mainly used if the exam has already been released and the teacher goes back and edits
     * the comment field for a particular student.
     *
     * @param Exam $exam
     * @param $studentId
     */
    public function updateFeedbackForStudent(Exam $exam, $studentId)
    {
        //magic
        //TODO: set up queue-able event to look up the student's access key and then update the output comment

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

    // Sends an email notification to the student that their exam has been graded
    public function notifyStudent(Exam $exam, Student $student) {

        // TODO: need API for emailing an individual student
    }

    // will release the exam, update stats and email all students who haven't been emailed to date.
    // Re-releasing an exam can send a different emailing letting all students know that scores have been changed
    public function releaseExam(Exam $exam) {
        $this->createFeedback($exam);
        if ($exam->released) {
            // TODO send 're-release' email to all students with grades
        } else {
            $exam->setReleased(true);
            // TODO send 'release' email to all students with grades
        }
    }

    public function showAnalytics(Exam $exam)
    {
        $students = $this->studentRepository->load_students_by_exam($exam->getId());

        return view('reports.exam_analytics')->with(['exam' => $exam, 'students' => $students]);
    }

    public function showExams()
    {
        $exams = $this->examDao->load_all_exams();

        //$students = $this->studentDao->load_all_students();
        return view('reports.exam_controls', compact('exams'));
    }

    /**
     * Returns the page with quality control tools for the given exam
     * @param Exam $exam
     */
    public function showQualityControl(Exam $exam)
    {

    }

    // displays the student_controls page to review feedback and send emails
    public function showStudents(Exam $exam)
    {
        // TODO: COMPILE RESULTS FOR THIS EXAM BEFORE VIEW HAPPENS
        $students = $this->studentRepository->load_students_by_exam($exam->getId());

        return view('reports.student_controls')->with(['exam' => $exam, 'students' => $students]);
    }

    // Show feedback for the selected student
    // TODO: create page with nav bars, etc to hold the doc
    public function showStudentFeedback(Exam $exam, Student $student) {
        return ('feedback for a student');
    }
}