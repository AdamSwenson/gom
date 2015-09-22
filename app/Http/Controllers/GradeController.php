<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests;
use App\Http\Requests\GradingRequest;

use App\Exam;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingTimeRepository;

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

    protected $dao;
    protected $reportController;

    /**
     * @param IExamRepository $IExamRepository
     * @param IElementRepository $elementRepository
     * @param IElementAssignmentRepository $elementAssignmentRepository
     * @param IElementScoreRepository $elementScoreRepository
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IQuestionScoreRepository $questionScoreRepository
     * @param IGradingTimeRepository $gradingTimeRepository
     * @param IStudentRepository $studentRepository
     */
    public function __construct(IExamRepository $IExamRepository,
                                IElementRepository $elementRepository,
                                IElementAssignmentRepository $elementAssignmentRepository,
                                IElementScoreRepository $elementScoreRepository,
                                IQuestionAssignmentRepository $questionAssignmentRepository,
                                IQuestionScoreRepository $questionScoreRepository,
                                IGradingTimeRepository $gradingTimeRepository,
                                IStudentRepository $studentRepository)
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
    }

    /**
     *  Launch the grade assignment page
     * @param Exam $exam
     */
    public function assign(Exam $exam)
    {
        $examId = $exam->getId();
        // get the max_scores and compute examMaxScore
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($examId);
        $examMaxScore = 20;

        foreach ($questionAssignments as $assignment) {
            //$examMaxScore += $assignment->getQuestion()->getMaxScore();
        }

        $gradeTypes = ['A+', 'A', 'A-',
            'B+', 'B', 'B-',
            'C+', 'C', 'C-',
            'D+', 'D', 'D-',
            'F'];

        // gradeCutoffs are the lowest values for each grade type
        // normally these will be retrieved from the values saved in the DB.

        $gradeCutoffs = [];
        //$gradeCutoffs = $exam->getGradeCutoffs(); // use cookie to hold these??
        // if gradecutoffs aren't set, calculate them...
        if ( empty($gradeCutoffs)) {
            $standardCutoffs = [.97, .93, .90, .87, .83, .80, .77, .73, .70, .67, .63, .60, 0];
            foreach ($standardCutoffs as $val) {
                // allow decimals if the exam has a very low maximum grade
                if ($examMaxScore < 25) $decRound = 1;
                else $decRound = 0;
                $gradeCutoffs[] = round($examMaxScore * $val, $decRound);
            }
        }

        $students = $this->studentDao->load_students_by_exam($examId);

        // calculate exam scores
        $examScores = [];
        foreach ($students as $student) {
            $questionItems = $this->questionScoreDao->load_for_student_on_exam($examId, $student->getId());
            $examScore = 0;
            foreach ($questionItems as $score) {
                if (isset($score->questionScore))
                    $examScore += $score->questionScore;
            }
            $examScores[] = $examScore;
        }
        return View::make('grade.grade_assign', ['exam' => $exam,
            'examScores' => $examScores,
            'gradeTypes' => $gradeTypes,
            'gradeCutoffs' => $gradeCutoffs]);
    }

    /**
     * Store grade assignments
     * @param Exam $exam
     * @return redirect
     */
    public function recordAssignments(Exam $exam)
    {
        // do stuff
        return redirect()->action('GradeController@index');
    }

    /**
     *  Presents a list of exams for grading and assignment of scores
     */
    public function index()
    {
        $exams = $this->examDao->load_all_exams();
        $numStudents = [];
        $numQuestions = [];
        $numGraded = [];
        foreach ($exams as $exam) {
            $examId = $exam->getId();
            $numStudents[$examId] = count($this->studentDao->load_students_by_exam($examId));
            $numQuestions[$examId] = count($this->questionAssignmentDao->load_all_for_exam($examId));
            // I'd like to have an indicator showing how many exams have been graded for each exam in the list.
            // Calculating and loading all the graded exams is a lot of work ( #students * #questions * #exams)
            // so maybe we should cache that value in the DB / redis.
            $numGraded[$examId] = '--';
        }

        return View::make('grade.grade_select_exam', ['exams' => $exams,
            'numStudents' => $numStudents, 'numQuestions' => $numQuestions, 'numGraded' => $numGraded]);
    }

    /**
     * Presents the exam for grading
     * @param Exam $exam
     * @return View
     */
    public function grade(Exam $exam)
    {
        $students = $this->studentDao->load_students_by_exam($exam);

        // TODO: do verification for exams. Must have 1 student and at least 1 question.
        if (sizeof($students) == 0) return ("No students found for this exam");

        // load all question assignments and all elements for those questions
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());
        $maxQuestionScores = NULL;
        if (sizeof($questionAssignments) == 0) return ('No questions found for this exam');
        foreach ($questionAssignments as $qAssignment) {
            $qNumber = $qAssignment->getQuestionNumber();
            $allElements[] = $this->elementAssignmentDao->load_elements($exam->getId(), $qNumber);
            // load maxQuestionScores TODO: uncomment thid when DB is built
            //$maxQuestionScores[$qNumber] = $qAssignment->getQuestion()->getMaxScore();
            $maxQuestionScores[$qNumber] = 20;
        }

        // load all current student scores & comments
        $allElementAssignments = $this->elementAssignmentDao->load_by_exam($exam->getId());
        foreach ($students as $student) {
            // load element scores & element comments for each student
            $elementScores = NULL;
            $elementComments = NULL;
            foreach ($allElementAssignments as $eleAssignment) {
                $aCommentScore = $this->elementScoreDao->load($eleAssignment->getElementAssignmentId(), $student->getId());
                if (isset($aCommentScore->score)) {
                    $aScore = $aCommentScore->getScore();
                } else {
                    $aScore = NULL;
                }
                $elementScores[] = $aScore;

                // grab the student-specific comment for this element
                if (isset($aCommentScore->comment_text)) {
                    $aCommentText = $aCommentScore->comment_text;
                } else {
                    $aCommentText = "";
                }
                $elementComments[] = $aCommentText;
            }
            $studentElementScores[] = $elementScores;
            $studentElementComments[] = $elementComments;

            // load question scores for each student
            $questionScores = NULL;
            foreach ($questionAssignments as $questionAssignment) {
                $aScore = $this->questionScoreDao->load($questionAssignment->getId(), $student->getId());
                if (isset($aScore->score)) {
                    $aScore = $aScore->getScore();
                } else
                    $aScore = NULL;
                $questionScores[] = $aScore;
            }
            $studentQuestionScores[] = $questionScores;

            // load grading times for each student
            if (isset ($this->gradingTimeDao->load($exam->getId(), $student->getId())->seconds)) {
                $examGradingTimes[] = $this->gradingTimeDao->load($exam->getId(), $student->getId())->seconds;
            } else
                $examGradingTimes[] = 0;
        }

        // load stock comments for each element
        $stockComments = [];
        foreach ($allElements as $aQuestion) {
            foreach ($aQuestion as $element) {
                $defaultComments = NULL;
                for ($i = 0; $i < count(Comment::$valences); $i++) {
                    $defaultComments[] = $this->elementDao->loadCommentByElementIdAndValence($element->getId(), $i)->getBody();
                }
                $stockComments[] = $defaultComments;
            }
        }

        return View::make('grade.grade_exam')->with(['exam' => $exam,
            'students' => $students,
            'questionAssignments' => $questionAssignments,
            'maxQuestionScores' => $maxQuestionScores,
            'allElements' => $allElements,
            'stockComments' => $stockComments,
            'examGradingTimes' => $examGradingTimes,
            'studentElementScores' => $studentElementScores,
            'studentElementComments' => $studentElementComments,
            'studentQuestionScores' => $studentQuestionScores
        ]);
    }

    /**
     * Records scores, comments and grading time
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function recordScore(Exam $exam, GradingRequest $request)
    {
        //Don't even get started if there's no student id
        if ($request->has('student_id')) {
            $studentId = $request->input('student_id');

            $itemId = null;

            //If the request is to record a question score, it follows this path
            if ($request->has('question_assignment_id')) {
                $this->dao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
                $itemId = $request->input('question_assignment_id');
            }
            //If it is to record an element score, it follows this path
            if ($request->has('element_id')) {
                $this->dao = app()->make('App\Repositories\Score\IElementScoreRepository');
                $itemId = $this->elementAssignmentDao->load_element_assignment_by_element($exam->getId(),
                    $request->input('element_id'))->getId();

                // if a comment has text with it, record that as well.
                if ($request->exists('comment_text')) {
                    $this->dao->recordCommentText($itemId, $studentId, $request->input('comment_text'));
                }
            }

            // record score fot the question or comment
            if ($request->exists('score')) {
                // if the score returns as 'NaN' that item's score has been removed, so delete from DB
                $score = $request->input('score');
                if ($score == NAN) {
                    //$this->dao->deleteScore
                } else {
                    $this->dao->record($itemId, $studentId, $score);
                }
            }

            // Check if the exam has been released.
            // A released exam will have its compiled feedback updated  for this student
            if ($exam->getReleased()) {
                $reportController = app()->make('App\Http\Controllers\ReportController');
                $reportController->updateFeedbackForStudent($exam, $studentId);
            }

            $this->recordTime($exam, $request);

        } else {
            //TODO Error handling
        }
    }

    /**
     * Record or add to the time spent grading a particular student's exam
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     */
    public function recordTime(Exam $exam, GradingRequest $request)
    {
        if ($request->has('student_id') && $request->has('time')) {
            $dao = app()->make('App\Repositories\Time\IGradingTimeRepository');
            $time = $dao->record($exam->getId(), $request->input('student_id'), $request->input('time'));
            return $time;
        } else {
            //TODO Error handling
        }
    }

    /**
     * Removes a question or element score when it has been deleted.
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     */
    public function removeScore(Exam $exam, GradingRequest $request)
    {
        if ($request->has('questionAssignmentId')) {
            $this->questionScoreDao->deleteScore($request['questionAssignmentId'], $request['studentId']);
        }

        if ($request->has('elementAssignmentId')) {
            $this->elementScoreDao->deleteScore($request['elementAssignmentId'], $request['studentId']);
        }
    }

    /**
     * Load the time spent grading a particular student exam
     *
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     */
    public function loadTime(Exam $exam, GradingRequest $request)
    {
        if ($request->has('student_id')) {
            $dao = app()->make('App\Repositories\Time\IGradingTimeRepository');
            $time = $dao->load($exam->getId(), $request->input('student_id'));
            return $time;
        }
    }

    /**
     * Loads array of statistics for grading time.
     * See IGradingStatsRepository for description of array.
     *
     * @param Exam $exam
     * @return mixed
     */
    public function loadStats(Exam $exam)
    {
        $dao = app()->make('App\Repositories\Time\IGradingStatsRepository');
        $stats = $dao->get_grading_time_stats($exam->getId());
        return $stats;
    }

    public function getAutoSID()
    {
    }

    /**
     * Alters the total number of exams to use in statistics
     */
    public function setTotalExams()
    {
    }
}