<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 11:22 AM
 */

namespace App\Http\Controllers\Report;

use App\Events\ExamReleasedEvent;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Jobs\Feedback\BuildFeedbackAllStudents;
use App\Jobs\Feedback\BuildFeedbackOneStudent;
use App\Jobs\Feedback\NotifyAllStudents;
use App\Jobs\Feedback\NotifySingleStudent;
use App\Repositories\Score\IScoreStatisticsRepository;
use App\Student;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Feedback\IFeedbackBuilder;
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
 * All operations require the user to be logged in.
 *
 * This does NOT handle student's access to
 * their comments.
 *
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{
    /** @var IElementScoreRepository */
    protected $elementScoreRepository;
    /** @var IAccessKeyRepository */
    protected $accessKeyDao;
    /** @var IFeedbackBuilder */
    protected $feedbackBuilder;
    /** @var IQuestionAssignmentRepository */
    protected $questionAssignmentRepository;
    /** @var IElementAssignmentRepository */
    protected $elementAssignmentRepository;
    /** @var IQuestionScoreRepository */
    protected $questionScoreRepository;
    /** @var ICommentRepository */
    protected $commentRepository;
    /** @var IStudentRepository */
    protected $studentRepository;
    /** @var IExamRepository */
    protected $examDao;
    /** @var IScoreStatisticsRepository */
    protected $scoreStatisticsRepository;

    /**
     * @param IAccessKeyRepository $accessKeyRepository
     * @param IExamRepository $examRepository
     * @param IFeedbackBuilder $feedbackBuilder
     * @param IStudentRepository $studentRepository
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IElementAssignmentRepository $elementAssignmentRepository
     * @param IQuestionScoreRepository $questionScoreRepository
     * @param IElementScoreRepository $elementScoreRepository
     * @param ICommentRepository $commentRepository
     * @param IStudentRepository $studentRepository
     * @param IScoreStatisticsRepository $scoreStatisticsRepository
     * @internal param IScoreStatisticsRepository $IScoreStatisticsRepository
     */
    public function __construct(
        IAccessKeyRepository $accessKeyRepository,
        IExamRepository $examRepository,
        IFeedbackBuilder $feedbackBuilder,
        IStudentRepository $studentRepository,
        IQuestionAssignmentRepository $questionAssignmentRepository,
        IElementAssignmentRepository $elementAssignmentRepository,
        IQuestionScoreRepository $questionScoreRepository,
        IElementScoreRepository $elementScoreRepository,
        ICommentRepository $commentRepository,
        IScoreStatisticsRepository $scoreStatisticsRepository
    )
    {
        $this->middleware('auth');
        $this->accessKeyDao = $accessKeyRepository;
        $this->examDao = $examRepository;
        $this->feedbackBuilder = $feedbackBuilder;
        $this->questionAssignmentRepository = $questionAssignmentRepository;
        $this->elementAssignmentRepository = $elementAssignmentRepository;
        $this->questionScoreRepository = $questionScoreRepository;
        $this->elementScoreRepository = $elementScoreRepository;
        $this->commentRepository = $commentRepository;
        $this->studentRepository = $studentRepository;
        $this->scoreStatisticsRepository = $scoreStatisticsRepository;
    }

    /**
     * Shows the page listing all exams for selecting report functions
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $exams = $this->examDao->load_all_exams();

        return view('reports.exam_controls', ['exams' => $exams]);
    }

    /**
     * Re-compiles the feedback for a particular student.
     *
     * This is mainly used if the exam has already been released and the teacher goes back and edits
     * the comment field for a particular student.
     *
     * @param Exam $exam
     * @param integer $studentId
     */
    public function updateFeedbackForStudent(Exam $exam, $studentId)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $student = Student::findOrFail($studentId);
        $job = (new BuildFeedbackOneStudent($exam, $student))->onQueue('default');
        $this->dispatch($job);
    }

    /**
     * Receives the command to create feedback for the exam and dispatches the
     * events to take care of it
     *
     * @param Exam $exam
     */
    public function createFeedback(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $job = (new BuildFeedbackAllStudents($exam))->onQueue('default');
        $this->dispatch($job);
    }


    /**
     * Sends an email notification to the student that their
     * exam has been graded with a link to access their feedback
     * @param Exam $exam
     * @param Student $student
     */
    public function notifyStudent(Exam $exam, Student $student)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        $this->authorize('access-object', $student);

        // added cutoff in case of empty email address
        if ( $student->getEmail() )
        {
            $job = (new NotifySingleStudent($exam, $student))->onQueue('emails');
            $this->dispatch($job);
        }
    }


    /**
     * Will release the exam, update stats and email all students who haven't been emailed to date.
     * Re-releasing an exam can send a different emailing letting all students know that scores have been changed
     * @param Exam $exam
     */
    public function releaseExam(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $this->createFeedback($exam);
        if ( ! $exam->isReleased() )
        {
            $exam->releaseExam();
        }
        $job = (new NotifyAllStudents($exam))->onQueue('emails');
        $this->dispatch($job);
    }

    /**
     * Deletes access keys for the exam and sets released flag to false.
     * Deleting keys will remove flags for student emails as well
     * @param Exam $exam
     */
    public function unreleaseExam(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

//        $exam->setReleased(false);
//        $exam->save();
        $keys = $this->accessKeyDao->getAccessKeysForExam($exam->getId());
        if ( ! empty($keys) )
        {
            foreach ( $keys as $key )
            {
                $this->accessKeyDao->removeAccessKey($key->getKey());
            }
        }

        $exam->hideExam();
    }


    /**
     * Displays the student_controls page to review feedback and send emails
     * @param Exam $exam
     * @return $this
     */
    public function showStudents(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        // compile feedback for all students
        $examId = $exam->getId();

        // this will return a Collection, potentially empty
        $students = $this->studentRepository->load_students_by_exam($exam->getId());

        //Check to make sure students are present
        if ( ! is_null($students) && count($students) > 0 )
        {
            //If the exam has not ben released, generate them all
            if ( ! $exam->isReleased() )
            {
                $this->feedbackBuilder->buildFeedback($examId);
            }

            //TODO Why the fuck is this redone?
            foreach ( $students as $student )
            {
                $this->feedbackBuilder->recompileFeedbackForStudent($examId, $student);
            }
        } else
        {
            //Set an error message
        }

        return view('reports.student_controls')->with(['exam' => $exam, 'students' => $students]);
    }

    /**
     * Show feedback for the selected student
     * @param Exam $exam
     * @param Student $student
     * @return $this
     */
    public function showStudentFeedback(Exam $exam, Student $student)
    {
        //Check that user is authorized to access student and exam
        $this->authorize('access-object', $exam);
        $this->authorize('access-object', $student);

        $accessKey = $this->accessKeyDao->getAccessKeyForStudent($exam->getId(), $student->getId());
        $data = $this->accessKeyDao->retrieveFeedback($accessKey);

        //Push student info into the feedback object
        $data->studentName = $student->getFullName();
        $data->studentIdentifier = $student->getStudentIdentifierAttribute();

        $showNav = true;

        return view('feedback.feedback')
            ->with([
                       'exam'    => $exam,
                       'student' => $student,
                       'data'    => $data,
                       'showNav' => $showNav,
                   ]);
//        return view('reports.student_feedback')->with(['exam' => $exam, 'student' => $student, 'data' => $data]);
    }

    /**
     * Displays all feedback for all students on an exam.
     * This is mainly for someone who wants to print out the feedback and provide it to
     * the students.
     *
     * TODO Implement this client side
     *
     * @param Exam $exam
     * @return $this
     */
    public function showFeedbackForAllStudentsOnExam(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $dataAll = [];
        $students = $this->studentRepository->load_students_by_exam($exam);
        foreach ( $students as $student )
        {
            $accessKey = $this->accessKeyDao->getAccessKeyForStudent($exam->getId(), $student->getId());

            $data = $this->accessKeyDao->retrieveFeedback($accessKey);

            //Push student info into the feedback object
            $data->name = $student->getFullName();
            $data->student_id = $student->getStudentIdentifierAttribute();

            //Add to data array
            $dataAll[] = $data;
        }

        return view('feedback.feedback')->with(['exam' => $exam, 'student' => $student, 'dataAll' => $dataAll]);
    }
}