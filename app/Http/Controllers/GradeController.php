<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests;
use App\Http\Requests\GradeAssignmentRequest;
use App\Http\Requests\GradingRequest;

use App\Exam;
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

use Illuminate\Support\Facades\Session;
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
     */
    public function __construct(IExamRepository $IExamRepository,
                                IElementRepository $elementRepository,
                                IElementAssignmentRepository $elementAssignmentRepository,
                                IElementScoreRepository $elementScoreRepository,
                                IQuestionAssignmentRepository $questionAssignmentRepository,
                                IQuestionScoreRepository $questionScoreRepository,
                                IGradingTimeRepository $gradingTimeRepository,
                                IStudentRepository $studentRepository,
                                IGradeAssignmentRepository $gradeAssignmentRepository)
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
        $examMaxScore = 0;

        foreach ($questionAssignments as $assignment) {
            $questionMax = $assignment->getQuestion()->getMaxScore();

            //If max question score not set, use the default max score
            if( empty($questionMax) ){ $questionMax = self::DEFAULT_MAX_QUESTION_SCORE; }

            //Add to the total exam score
            $examMaxScore += $questionMax;
        }

        //Load an array of the letter grades (i.e., A+, A, A-)
        $gradeTypes = GradeFactory::getDisplayValuesOfGrades();

        //Load an array of minimum scores for each grade
        $gradeCutoffs = $this->getGradeCutoffs($exam, $examMaxScore);

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
        return View::make('grade.grade_assign', [
            'exam' => $exam,
            'examScores' => $examScores,
            'examMaxScore' => $examMaxScore,
            'gradeTypes' => $gradeTypes,
            'gradeCutoffs' => $gradeCutoffs
        ]);
    }

    /**
     *  Grade cutoffs are the lowest values for each grade type
     * normally these will be retrieved from the values saved in the DB.
     *
     * If no cutoffs are set in the database, this will generate default values.
     * @param Exam $exam
     * @param integer $examMaxScore
     * @return array
     */
    protected function getGradeCutoffs(Exam $exam, $examMaxScore)
    {
        $gradeCutoffs = $this->gradeAssignmentDao->load_grade_min_scores_for_exam($exam);

        // if gradecutoffs aren't set, calculate them...
        if ( empty($gradeCutoffs)) {
            $gradeCutoffs = [];
            foreach (GradeFactory::getDefaultCutoffsOfGrades() as $val) {
                // allow decimals if the exam has a very low maximum grade
                if ($examMaxScore < 25) $decRound = 1;
                else $decRound = 0;
                $gradeCutoffs[] = round($examMaxScore * $val, $decRound);
            }
        }

        return $gradeCutoffs;
    }

    /**
     * Store grade assignments
     * @param Exam $exam
     * @param GradeAssignmentRequest $request
     * @return redirect
     */
    public function recordAssignments(Exam $exam, GradeAssignmentRequest $request)
    {
        //This will hold the incoming assignments after they have been processed and before they are written to the db
        $assignments = [];

        //This will hold the grades which are not being assigned and slated for deletion if they were in the db
        $nonAssigned = [];

        //Pull out each value to assign, make a grade object and push into $assignments
        for($i=0; $i<=12; $i++)
        {
            if( ! empty($request->input(self::GRADE_ASSIGNMENT_FIELD_BASE . '' . $i)))
            {
                $grade = GradeFactory::loadByOrder($i);
                $minScore = $request->input(self::GRADE_ASSIGNMENT_FIELD_BASE . $i);
                //push into array
                $assignments[] = ['minScore' => $minScore, 'grade' => $grade];
            }
            else
            {
                //If a letter grade was not assigned, make note so any preexisting value can be removed
                $nonAssigned[] = $i;
            }
        }

        //Request validator already checked for consistency, so let's write to the db
        foreach($assignments as $assign)
        {
            $this->gradeAssignmentDao->record_grade_assignment($exam, $assign['grade'], $assign['minScore']);
        }

        //Delete any pre-existing grades which were not assigned on this request
        if( ! empty($nonAssigned))
        {
            foreach($nonAssigned as $naOrder)
            {
                $grade = GradeFactory::loadByOrder($naOrder);
                $this->gradeAssignmentDao->delete_grade_assignment($exam, $grade);
            }
        }

        // TODO: Add error handling
        // TODO: Add flash message about success? Otherwise it may be weird to just be kicked back to what seems to be an earlier page.
        // do stuff TODO: add logic to record the cutoffs to the DB (?)
        return redirect()->action('GradeController@index');
    }

//    /**
//     * Makes sure that transitivity holds for the minimum scores
//     * @param array $assignments Array with keys 'minScore' and 'grade'
//     * @return bool False if inconsistent; true if consistent
//     */
//    protected function checkAssignmentConsistency($assignments)
//    {
//        for($i=0; $i<count($assignments); $i++ )
//        {
//            //For each value except the last one, make sure it is greater than it's successor
//            if( ($i+1 != count($assignments)) && ($assignments[$i]['minScore'] <= $assignments[$i + 1]['minScore']))
//            {
//                return false;
//            }
//        }
//        return true;
//    }

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
            // load maxQuestionScores
            $maxQuestionScores[$qNumber] = $qAssignment->getQuestion()->getMaxScore();

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