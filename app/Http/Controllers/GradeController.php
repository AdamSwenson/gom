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
     */
    public function __construct(IExamRepository $IExamRepository,
                                IElementRepository $elementRepository,
                                IElementAssignmentRepository $elementAssignmentRepository,
                                IElementScoreRepository $elementScoreRepository,
                                IQuestionAssignmentRepository $questionAssignmentRepository,
                                IQuestionScoreRepository $questionScoreRepository,
                                IGradingTimeRepository $gradingTimeRepository)
    {
        $this->middleware('auth');
        $this->examDao = $IExamRepository;
        $this->questionAssignmentDao = $questionAssignmentRepository;
        $this->elementDao = $elementRepository;
        $this->elementAssignmentDao = $elementAssignmentRepository;
        $this->elementScoreDao = $elementScoreRepository;
        $this->questionScoreDao = $questionScoreRepository;
        $this->gradingTimeDao = $gradingTimeRepository;
    }

    /**
     *  Presents a list of exams to grade
     */
    public function index()
    {
        $exams = $this->examDao->load_all_exams();

        return View::make('grade.grade_select_exam', compact('exams'));
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

        // TODO: do verification for exams. Must have 1 student and at least 1 question.
        if (sizeof($students) == 0 ) return ("No students found for this exam");

        // load all question assignments and all elements for those questions
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());

        if(sizeof($questionAssignments) == 0) return ('No questions found for this exam');
        foreach ($questionAssignments as $qAssignment) {
            $allElements[] = $this->elementAssignmentDao->load_elements($exam->getId(), $qAssignment->getQuestionNumber());
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
            $time = $dao->load($exam->id, $request->input('student_id'));
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
        $stats = $dao->get_grading_time_stats($exam->id);
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