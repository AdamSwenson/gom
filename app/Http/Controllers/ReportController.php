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
    /**
     * @var IScoreStatisticsRepository
     */
    private $scoreStatisticsRepository;

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
        IStudentRepository $studentRepository,
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
        if ($student->getEmail())
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
        if (!$exam->isReleased())
        {
            $exam->releaseExam();
//            $exam->setReleased(true);
//            $exam->save();
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
        if (!empty($keys))
        {
            foreach ($keys as $key)
            {
                $this->accessKeyDao->removeAccessKey($key->getKey());
            }
        }

        $exam->hideExam();
    }

    /**
     * Display the analytics page for the exam
     * @param Exam $exam
     * @return $this
     */
    public function showAnalytics(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $students = $this->studentRepository->load_students_by_exam($exam->getId());

        $questionScores = [];
        $numberOfQuestions = count($this->questionAssignmentRepository->load_all_for_exam($exam->getId()));

        if ($numberOfQuestions > 0)
        {
            for ($i = 1; $i <= $numberOfQuestions; $i++)
            {

                /*
                 * Was getting error because this method on questionScoreRepository
                 * returns an array of stdClass objects. So updating to extract the scores from
                 * those objects
                 */
                $oneSetOfScores = [];
                $arrayOfStdObjects = $this->questionScoreRepository->load_all_for_question_number($exam->getId(), $i);
                foreach ($arrayOfStdObjects as $obj)
                {
                    array_push($oneSetOfScores, $obj->score);
                }
                //back to what was originally here
                $questionScores[] = $oneSetOfScores;
            }
        }

        $this->scoreStatisticsRepository->loadStats($exam);
        $questionScoresByQNumber = $this->questionScoreRepository->load_all_for_exam($exam->id);
        $elementScoresByQENumber = $this->elementScoreRepository->load_all_for_exam($exam->id);

        return view('reports.exam_analytics')->with([
            'exam' => $exam,
            'students' => $students,
            'questionScores' => json_encode($questionScores),
            'questionScoresByQNumber' => json_encode($questionScoresByQNumber),
            'questionStats' => $this->scoreStatisticsRepository->questionAssignmentStats->toJson(),
            'elementStats' => $this->scoreStatisticsRepository->elementAssignmentStats->toJson(),
            'elementScoresByQENumber' => json_encode($elementScoresByQENumber)
        ]);
    }

    function standardDeviation($array)
    {
        // square root of sum of squares divided by N-1
        return sqrt(array_sum(array_map(function ($x, $mean)
            {
                return pow($x - $mean, 2);
            }, $array, array_fill(0, count($array),
                (array_sum($array) / count($array))))) / (count($array) - 1));
    }

    // Function to calculate square of value - mean
    function sd_square($x, $mean)
    {
        return pow($x - $mean, 2);
    }

    /**
     * Shows the page listing all exams for selecting report functions
     * @return \Illuminate\View\View
     */
    public function showExams()
    {
        $exams = $this->examDao->load_all_exams();
        return view('reports.exam_controls', ['exams' => $exams]);
    }

    /**
     * Returns the page with quality control tools for the given exam
     * @param Exam $exam
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showQualityControl(Exam $exam)
    {
//        $this->featureInDevelopment();

        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $scoreStatsDao = app()->make('App\Repositories\Score\IScoreStatisticsRepository');
        $gradingTimeStatsDao = app()->make('App\Repositories\Time\IGradingStatsRepository');

        $gradingTimeStats = $gradingTimeStatsDao->get_grading_time_stats($exam->id);

        $scoresAndTimes = $scoreStatsDao->getScoresAndTimesByGradedOrder($exam);

        return view('reports.quality_control', [
            'scoresAndTimes' => $scoresAndTimes,
            //      'averageTime' => $gradingTimeStats['averageExamTime']
        ]);
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
        $students = $this->studentRepository->load_students_by_exam($exam->getId());

        if (!$exam->isReleased())
        {
            $this->feedbackBuilder->buildFeedback($examId);
        }
        foreach ($students as $student)
        {
            $this->feedbackBuilder->recompileFeedbackForStudent($examId, $student);
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
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        $this->authorize('access-object', $student);

        $accessKey = $this->accessKeyDao->getAccessKeyForStudent($exam->getId(), $student->getId());
        $data = $this->accessKeyDao->retrieveFeedback($accessKey);

        //Push student info into the feedback object
        $data->name = $student->getFullName();
        $data->student_id = $student->getStudentIdentifierAttribute();

        $showNav = true;
        return view('feedback.feedback')->with(['exam' => $exam, 'student' => $student, 'data' => $data, 'showNav' => $showNav]);
//        return view('reports.student_feedback')->with(['exam' => $exam, 'student' => $student, 'data' => $data]);
    }

    /**
     * Displays all feedback for all students on an exam.
     * This is mainly for someone who wants to print out the feedback and provide it to
     * the students.
     * @param Exam $exam
     * @return $this
     */
    public function showFeedbackForAllStudentsOnExam(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $dataAll = [];
        $students = $this->studentRepository->load_students_by_exam($exam);
        foreach ($students as $student)
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