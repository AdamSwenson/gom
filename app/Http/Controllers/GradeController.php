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
    protected $dao;
    protected $IExamRepository;

    public function __construct(IExamRepository $IExamRepository, IElementRepository $elementRepository,
                                IElementAssignmentRepository $elementAssignmentRepository,
                                IQuestionAssignmentRepository $questionAssignmentRepository,
                                IElementScoreRepository $elementScoreRepository,
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

        if( empty($students) ) return ("No students found for this exam");

        // load all question assignments and all elements for those questions
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());
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
                /* commented out until we figure out what broke.
                $aScore = $this->elementScoreDao->load($eleAssignment->getElementAssignmentId(), $student->getId());
                if ( isset($aScore->score) ) {
                    $aScore = $aScore->getScore();
                } else
                    $aScore = NULL;
                $elementScores[] = $aScore;

                $aComment = "test comment, element assignment #".$eleAssignment->getId();
                $elementComments[] = $aComment;
                */
                $elementScores[] = rand(0, 10);
                $elementComments[] = 'a test comment because Adam broke stuff';
            }
            $studentElementScores[] = $elementScores;
            $studentElementComments[] = $elementComments;

            // load question scores for each student
            $questionScores = NULL;
            foreach ($questionAssignments as $questionAssignment) {
                $aScore = $this->questionScoreDao->load($questionAssignment->getId(), $student->getId());
                if ( isset($aScore->score) ) {
                    $aScore = $aScore->getScore();
                } else
                    $aScore = NULL;
                $questionScores[] = $aScore;
            }
            $studentQuestionScores[] = $questionScores;

            // load grading times for each student
            $examGradingTimes[] = $this->gradingTimeDao->load($exam->getId(), $student->getId() )->seconds;
        }

        // load stock comments for each element
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
     * Records scores as well as time and any other information
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function recordScore(Exam $exam, GradingRequest $request)
    {
        //Don't even get started if there's no student id and score
        if ($request->has('student_id') && $request->has('score')) {
            $studentId = $request->input('student_id');
            $score = $request->input('score');

            //If the request is to record a question score, it follows this path
            if ($request->has('question_assignment_id')) {
                $this->dao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
                $itemId = $request->input('question_assignment_id');
            } //If it is to record an element score, it follows this path
            elseif ($request->has('element_assignment_id')) {
                $this->dao = app()->make('App\Repositories\Score\IElementScoreRepository');
                $itemId = $request->input('element_assignment_id');
            }
            $this->dao->record($itemId, $studentId, $score);
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
            $time = $dao->record($exam->id, $request->input('student_id'), $request->input('time'));
            return $time;
        } else {
            //TODO Error handling
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