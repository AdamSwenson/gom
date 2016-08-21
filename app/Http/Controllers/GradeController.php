<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests;
use App\Http\Requests\GradeAssignmentRequest;
use App\Http\Requests\GradingRequest;

use App\Exam;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Jobs\AsyncStorage\UpdateAllStoredNumGraded;
use App\Jobs\AsyncStorage\UpdateStoredExamStats;
use App\Jobs\AsyncStorage\UpdateStoredNumGraded;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Grade\GradeFactory;
use App\Repositories\Grade\IGradeAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingTimeRepository;

use App\Repositories\Utilities\IJsDataPreparation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use JavaScript;

/**
 * Class GradeController
 *
 * This handles all operations involved in displaying the grade input page and
 * recording the actual grades as they are assigned.
 *
 * @package App\Http\Controllers
 */
class GradeController extends Controller
{
    const INVALID_GRADE_ASSIGNMENT_MESSAGE = 'The criteria you entered were inconsistent.';

    const GRADE_ASSIGNMENT_FIELD_BASE = 'gradeGroup';

    /** If there is no max score set in the database, use this */
    const DEFAULT_MAX_QUESTION_SCORE = 20;

    /** @var  IExamRepository */
    protected $examDao;

    /** @var  IQuestionAssignmentRepository */
    protected $questionAssignmentDao;

    /** @var  IElementRepository */
    protected $elementDao;

    /** @var  IElementAssignmentRepository */
    protected $elementAssignmentDao;

    /** @var  IElementScoreRepository */
    protected $elementScoreDao;

    /** @var  IQuestionScoreRepository */
    protected $questionScoreDao;

    /** @var  IGradingTimeRepository */
    protected $gradingTimeDao;

    /** @var  IGradeAssignmentRepository */
    protected $gradeAssignmentDao;

    protected $dao;

    protected $reportController;

    /** @var IStudentRepository */
    protected $studentDao;
    /**
     * @var IJsDataPreparation
     */
    private $jsonPrep;

    /**
     * @param IExamRepository $IExamRepository
     * @param IElementRepository $elementRepository
     * @param IElementAssignmentRepository $elementAssignmentRepository
     * @param IElementScoreRepository $elementScoreRepository
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IQuestionScoreRepository $questionScoreRepository
     * @param IGradingTimeRepository $gradingTimeRepository
     * @param IStudentRepository $studentRepository
     * @param IGradeAssignmentRepository $gradeAssignmentRepository
     * @param IJsDataPreparation $jsonPrep
     */
    public function __construct(IExamRepository $IExamRepository,
                                IElementRepository $elementRepository,
                                IElementAssignmentRepository $elementAssignmentRepository,
                                IElementScoreRepository $elementScoreRepository,
                                IQuestionAssignmentRepository $questionAssignmentRepository,
                                IQuestionScoreRepository $questionScoreRepository,
                                IGradingTimeRepository $gradingTimeRepository,
                                IStudentRepository $studentRepository,
                                IGradeAssignmentRepository $gradeAssignmentRepository,
IJsDataPreparation $jsonPrep)
    {
        $this->middleware('auth');
        $this->examDao = $IExamRepository;
        $this->questionAssignmentDao = $questionAssignmentRepository;
        $this->elementDao = $elementRepository;
        $this->elementAssignmentDao = $elementAssignmentRepository;
        $this->elementScoreDao = $elementScoreRepository;
        $this->questionScoreDao = $questionScoreRepository;
        $this->gradingTimeDao = $gradingTimeRepository;
        $this->studentDao = $studentRepository;
        $this->gradeAssignmentDao = $gradeAssignmentRepository;
        $this->jsonPrep = $jsonPrep;
    }

    /**
     *  Presents a list of exams for grade and assignment of scores
     */
    public function index()
    {
        $this->dispatch(new UpdateAllStoredNumGraded());

        $storedExamStatsDao = app()->make('App\Repositories\Exam\IStoredExamStatsRepository');
        $numGradedDao = app()->make('App\Repositories\Exam\INumberGradedRepository');

        $exams = $this->examDao->load_all_exams();
        $numStudents = [];
        $numQuestions = [];
        $numGraded = [];
        foreach ( $exams as $exam )
        {
            $examId = $exam->getId();

            $numStudents[ $examId ] = $storedExamStatsDao->getNumberStudents($exam);
            $numQuestions[ $examId ] = $storedExamStatsDao->getNumberQuestions($exam);

            // I'd lik_e to have an indicator showing how many exams have been graded for each exam in the list.
            // Calculating and loading all the graded exams is a lot of work ( #students * #questions * #exams)
            // so maybe we should cache that value in the DB / redis.
            $numGraded[ $examId ] = $numGradedDao->getNumberGraded($exam);
        }

        return View::make('grade.grade_select_exam', [
            'exams'        => $exams,
            'numStudents'  => $numStudents,
            'numQuestions' => $numQuestions,
            'numGraded'    => $numGraded,
        ]);
    }

    /**
     * Presents the exam for grade
     * @param Exam $exam
     * @return View
     */
    public function grade(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $students = $this->studentDao->load_students_by_exam($exam);
        // load all question assignments and all elements for those questions
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());
        $maxQuestionScores = [];

        // return to grade select if 0 students or 0 questions
        if ( sizeof($students) == 0 || sizeof($questionAssignments) == 0 )
        {
            return redirect()->action('GradeController@index');
        }

        foreach ( $questionAssignments as $qAssignment )
        {
            $qNumber = $qAssignment->getQuestionNumber();
            $qIndex = $qNumber - 1;
            $allElements[] = $this->elementAssignmentDao->load_elements($exam->getId(), $qNumber);
            // load maxQuestionScores
            $maxQuestionScores[ $qIndex ] = $qAssignment->getQuestion()->getMaxScore();
        }

        // load all current student scores & comments
        $allElementAssignments = $this->elementAssignmentDao->load_by_exam($exam->getId());
        foreach ( $students as $student )
        {
            // load element scores & element comments for each student
            $elementScores = null;
            $elementComments = null;
            foreach ( $allElementAssignments as $eleAssignment )
            {
                $aCommentScore = $this->elementScoreDao->load($eleAssignment->getElementAssignmentId(), $student->getId());
                if ( isset($aCommentScore->score) )
                {
                    $aScore = $aCommentScore->getScore();
                } else
                {
                    $aScore = null;
                }
                $elementScores[] = $aScore;

                // grab the student-specific comment for this element
                if ( isset($aCommentScore->comment_text) )
                {
                    $aCommentText = $aCommentScore->comment_text;
                } else
                {
                    $aCommentText = "";
                }
                $elementComments[] = $aCommentText;
            }
            $studentElementScores[] = $elementScores;
            $studentElementComments[] = $elementComments;

            // load question scores for each student
            $questionScores = null;
            foreach ( $questionAssignments as $questionAssignment )
            {
                $aScore = $this->questionScoreDao->load($questionAssignment->getId(), $student->getId());
                if ( isset($aScore->score) )
                {
                    $aScore = $aScore->getScore();
                } else
                {
                    $aScore = null;
                }
                $questionScores[] = $aScore;
            }
            $studentQuestionScores[] = $questionScores;

            // load grade times for each student
            if ( isset ($this->gradingTimeDao->load($exam->getId(), $student->getId())->seconds) )
            {
                $examGradingTimes[] = $this->gradingTimeDao->load($exam->getId(), $student->getId())->seconds;
            } else
            {
                $examGradingTimes[] = 0;
            }
        }
        $stockCommentsJson = $this->makeStockCommentsJson($allElements);


        $studentGrades = [];
        foreach ( $students as $s )
        {
            $studentGrades[] = 'Letter grade';
        }

        $questionsJson = $this->makeQuestionsJson($exam);
        $studentsJson = $this->makeStudentJson($exam);
        $gradesJson = $this->makeGradesJson();

        //added
//        $studentElementComments = json_encode($studentElementComments, JSON_FORCE_OBJECT);
//        $studentElementScores = json_encode($studentElementScores, JSON_FORCE_OBJECT);
//        $studentQuestionScores = json_encode($studentQuestionScores, JSON_FORCE_OBJECT);
//        $examGradingTimes = json_encode($examGradingTimes, JSON_FORCE_OBJECT);
//        $studentGrades = json_encode($studentGrades, JSON_FORCE_OBJECT);
//        $maxScores = json_encode($maxQuestionScores, JSON_FORCE_OBJECT);
//        $numQuestions = count($questionAssignments);

//        Javascript::put([
//            'exam'                   => $exam,
//            'students'               => $students,
//            'questionAssignments'    => $questionAssignments,
//            'maxQuestionScores'      => $maxQuestionScores,
//            'allElements'            => $allElements,
//            'stockCommentsJson'      => $stockCommentsJson,
//            'examGradingTimes'       => $examGradingTimes,
//            'studentElementScores'   => $studentElementScores,
//            'studentElementComments' => $studentElementComments,
//            'studentQuestionScores'  => $studentQuestionScores,
//            'studentGrades'          => $studentGrades,
//            'questionsJson'          => $questionsJson,
//            'studentsJson'           => $studentsJson,
//            'gradesJson'             => $gradesJson,
//        ]);

//        return View::make('development.newTable')->with([
//        return View::make('development.newGrading')->with([
        return View::make('grade.newGrading')->with([
                                                              'exam'                   => $exam,
                                                              'students'               => $students,
                                                              'questionAssignments'    => $questionAssignments,
                                                              'maxQuestionScores'      => $maxQuestionScores,
                                                              'allElements'            => $allElements,
                                                              'stockCommentsJson'      => $stockCommentsJson,
                                                              'examGradingTimes'       => $examGradingTimes,
                                                              'studentElementScores'   => $studentElementScores,
                                                              'studentElementComments' => $studentElementComments,
                                                              'studentQuestionScores'  => $studentQuestionScores,
                                                              'studentGrades'          => $studentGrades,
                                                              'questionsJson'          => $questionsJson,
                                                              'studentsJson'           => $studentsJson,
                                                              'gradesJson'             => $gradesJson,
                                                          ]);
    }

    /**
     * Builds the json object containing questions which the page js expects
     * Also injects the object into the view as GOM.questions
     * @param Exam $exam
     * @return string
     */
    public function makeQuestionsJson(Exam $exam)
    {
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());
        //encode =true , inject=false
        return $this->jsonPrep->makeQuestionsJson($questionAssignments);
    }


    /**
     * Builds the json object containing students which the page js expects
     * Also injects the object into the view as GOM.students
     * @param Exam $exam
     * @return string
     */
    public function makeStudentJson(Exam $exam)
    {
        $students = $this->studentDao->load_students_by_exam($exam);
        //encode =true , inject=false
        return $this->jsonPrep->makeStudentJson($students);
    }

    /**
     * Makes the object which the page's javascript expects.
     * Also injects the object into the view GOM.stockComments
     * @param $allElements
     * @return array
     */
    public function makeStockCommentsJson($allElements)
    {
        //encode =true , inject=false
        return $this->jsonPrep->makeStockCommentsJson($allElements);
    }

    /**
     * Makes json of standard grade values
     * Also injects into view as GOM.grades
     * @return string
     */
    public function makeGradesJson()
    {
        //encode =true , inject=false
        return $this->jsonPrep->makeGradesJson();
    }


//    /**
//     * Load the time spent grade a particular student exam
//     *
//     * @param Exam $exam
//     * @param GradingRequest $request
//     * @return mixed
//     */
//    public function loadTime(Exam $exam, GradingRequest $request)
//    {
//        //Check that user owns the exam
//        $this->authorize('access-object', $exam);
//
//        if ( $request->has('student_id') )
//        {
//            $dao = app()->make('App\Repositories\Time\IGradingTimeRepository');
//            $time = $dao->load($exam->getId(), $request->input('student_id'));
//
//            return $time;
//        }
//    }
//
//    /**
//     * Loads array of statistics for grade time.
//     * See IGradingStatsRepository for description of array.
//     *
//     * @param Exam $exam
//     * @return mixed
//     */
//    public function loadStats(Exam $exam)
//    {
//        //Check that user owns the exam
//        $this->authorize('access-object', $exam);
//
//        $dao = app()->make('App\Repositories\Time\IGradingStatsRepository');
//        $stats = $dao->get_grading_time_stats($exam->getId());
//
//        return $stats;
//    }
//
//    /**
//     * This will check whether
//     * @param Exam $exam
//     * @param Student $student
//     */
//    public function updateNumberGraded(Exam $exam, Student $student)
//    {
//
//    }
//

}