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
     *  Launch the grade assignment page
     * @param Exam $exam
     * @return string
     */
    public function assign(Exam $exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $examId = $exam->getId();

        // get the max_scores and compute examMaxScore
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($examId);
        $examMaxScore = 0;

        foreach ( $questionAssignments as $assignment )
        {
            $questionMax = $assignment->getQuestion()->getMaxScore();

            //If max question score not set, use the default max score
            if ( empty($questionMax) )
            {
                $questionMax = self::DEFAULT_MAX_QUESTION_SCORE;
            }

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
        foreach ( $students as $student )
        {
            $questionItems = $this->questionScoreDao->load_for_student_on_exam($examId, $student->getId());
            // Don't include any students who haven't been graded
            if ( ! $this->examGraded($questionItems) )
            {
                continue;
            }

            $examScore = 0;
            foreach ( $questionItems as $score )
            {
                if ( isset($score->questionScore) )
                {
                    $examScore += $score->questionScore;
                }
            }
            $examScores[] = $examScore;
        }

        if ( empty($students) || empty($examScores) )
        {
            return ('Either students or exam scores are empty');
        }

        return View::make('grade.grade_assign', [
            'exam'         => $exam,
            'examScores'   => $examScores,
            'examMaxScore' => $examMaxScore,
            'gradeTypes'   => $gradeTypes,
            'gradeCutoffs' => $gradeCutoffs,
        ]);
    }

    /**
     * @param $questionItems
     * @return bool
     */
    protected function examGraded($questionItems)
    {
        $graded = false;
        foreach ( $questionItems as $questionItem )
        {
            if ( $questionItem->questionScore != null )
            {
                $graded = true;
                break;
            }
        }

        return $graded;
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
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $gradeCutoffs = $this->gradeAssignmentDao->load_grade_min_scores_for_exam($exam);

        // if gradecutoffs aren't set, calculate them...
        if ( empty($gradeCutoffs) )
        {
            $gradeCutoffs = [];
            foreach ( GradeFactory::getDefaultCutoffsOfGrades() as $val )
            {
                // allow decimals if the exam has a very low maximum grade
                if ( $examMaxScore < 25 )
                {
                    $decRound = 1;
                } else
                {
                    $decRound = 0;
                }
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
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        //This will hold the incoming assignments after they have been processed and before they are written to the db
        $assignments = [];
        //This will hold the grades which are not being assigned and slated for deletion if they were in the db
        $nonAssigned = [];

        try
        {
            //Pull out each value to assign, make a grade object and push into $assignments
            for ( $i = 0; $i <= 12; $i++ )
            {
                //Check that the field has a value. If just try checking the value, may
                //run into trouble with empty(0) for F grade.
                if ( $request->has(self::GRADE_ASSIGNMENT_FIELD_BASE . $i) )
                {
                    $grade = GradeFactory::loadByOrder($i);
                    $minScore = $request->input(self::GRADE_ASSIGNMENT_FIELD_BASE . $i);
                    //push into array to be recorded
                    $assignments[] = ['minScore' => $minScore, 'grade' => $grade];
                } else
                {
                    //If a letter grade was not assigned, make note so any preexisting value can be removed
                    $nonAssigned[] = $i;
                }
            }

            //Request validator already checked for consistency, so let's write to the db
            foreach ( $assignments as $assign )
            {
                $this->gradeAssignmentDao->record_grade_assignment($exam, $assign['grade'], $assign['minScore']);
            }

            //Delete any pre-existing grades which were not assigned on this request
            if ( ! empty($nonAssigned) )
            {
                foreach ( $nonAssigned as $naOrder )
                {
                    $grade = GradeFactory::loadByOrder($naOrder);
                    $this->gradeAssignmentDao->delete_grade_assignment($exam, $grade);
                }
            }

            flash()->success('Grade assignments have been recorded');

        } catch ( \Exception $e )
        {
            Log::error('Problem recording grade assignments ' . $e->getMessage());

            flash()->error('There was a problem recording the grade assignments. Please try again. If the problem persists, please let us know');
        }

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

        //$studentsJson = $this->makeStudentJson($exam);
        //$gradesJson = $this->makeGradesJson();
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
     * Records scores, comments and grade time
     * @param Exam $exam
     * @param GradingRequest $request
     * @return Response json
     * @throws \Exception
     */
    public function recordScore(Exam $exam, GradingRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        try
        {
            //Don't even get started if there's no student id
            if ( ! $request->has('student_id') )
            {
                throw new \Exception('No student id set in grade request');
            }

            $studentId = $request->input('student_id');

            $itemId = null;

            //If the request is to record a question score, it follows this path
            if ( $request->has('question_assignment_id') )
            {
                $this->dao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
                $itemId = $request->input('question_assignment_id');
            }
            //If it is to record an element score, it follows this path
            if ( $request->has('element_id') )
            {
                $this->dao = app()->make('App\Repositories\Score\IElementScoreRepository');
                $itemId = $this->elementAssignmentDao->load_element_assignment_by_element($exam->getId(),
                                                                                          $request->input('element_id'))->getId();

                // if a comment has text with it, record that as well.
                if ( $request->exists('comment_text') )
                {
                    $this->dao->recordCommentText($itemId, $studentId, $request->input('comment_text'));
                }
            }

            // record score fot the question or comment
            if ( $request->exists('score') )
            {
                // if the score returns as 'NaN' that item's score has been removed, so delete from DB
                $score = $request->input('score');
                if ( $score == NAN )
                {
                    //$this->dao->deleteScore
                } else
                {
                    $this->dao->record($itemId, $studentId, $score);
                }
            }

            // Check if the exam has been released.
            // A released exam will have its compiled feedback updated  for this student
            if ( $exam->getReleased() )
            {
                $reportController = app()->make('App\Http\Controllers\Report\ReportController');
                $reportController->updateFeedbackForStudent($exam, $studentId);
            }

            $this->recordTime($exam, $request);

            $this->dispatch(new UpdateStoredNumGraded($exam));

            return $this->sendAjaxSuccess();

        } catch ( \Exception $e )
        {
            throw $e;

            return $this->sendAjaxFailure();

        }
    }

    /**
     * Record or add to the time spent grade a particular student's exam
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     */
    public function recordTime(Exam $exam, GradingRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        if ( $request->has('student_id') && $request->has('time') )
        {
            $dao = app()->make('App\Repositories\Time\IGradingTimeRepository');
            $time = $dao->record($exam->getId(), $request->input('student_id'), $request->input('time'));

            return $time;
        }
    }

    /**
     * Removes a question or element score when it has been deleted.
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function removeScore(Exam $exam, GradingRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        try
        {
            //Don't even get started if there's no student id
            if ( ! $request->has('student_id') )
            {
                throw new \Exception('No student id set in grade request');
            }

            $studentId = $request->input('student_id');

            if ( $request->has('question_assignment_id') )
            {
                $this->questionScoreDao->deleteScore($request['question_assignment_id'], $studentId);
            }

            // at this point, this isn't used as there is no means to reset an element score to ungraded.
            // Since the grade page doesn't store element assignment info, the element id must be used.
            if ( $request->has('element_id') )
            {
                $eAssignid = $this->elementAssignmentDao->load_element_assignment_by_element($exam->getId(), $request['element_assignment_id']);
                $this->elementScoreDao->deleteScore($eAssignid, $studentId);
            }

            return $this->sendAjaxSuccess();

        } catch ( \Exception $e )
        {
            throw $e;

            return $this->sendAjaxFailure();
        }
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
//        $questionIndex = 0;
//        $questions = [];
//        foreach ( $questionAssignments as $qa )
//        {
//            $questions[ $questionIndex ] = [
//                'questionIndex'        => $questionIndex,
//                'questionName'         => $qa->getQuestionName(),
//                'questionNumber'       => $qa->getQuestionNumber(),
//                'maxScore'             => $qa->getQuestion()->getMaxScore(),
//                'questionAssignmentId' => $qa->id,
//            ];
//            $questionIndex++;
//        }
//
//        Javascript::put(['questions' => $questions]);
//
//        return json_encode($questions, JSON_FORCE_OBJECT);
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
//        $studentIndex = 0;
//        $s = [];
//        foreach ( $students as $student )
//        {
//            $s[ $studentIndex ] = [
//                'studentIndex'      => $studentIndex, //this is here so can use with component
//                'studentId'         => $student->id,
//                'studentIdentifier' => $student->student_identifier,
//                'firstName'         => $student->first_name,
//                'lastName'          => $student->last_name,
//            ];
//            $studentIndex++;
//        }
//
//
//        //send to page
//        Javascript::put(['students' => $s]);
//
//        return json_encode($s, JSON_FORCE_OBJECT);

        // load all question assignments and all elements for those questions

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
//        // load stock comments for each element
//        $stockComments = [];
//        foreach ( $allElements as $aQuestion )
//        {
//            foreach ( $aQuestion as $element )
//            {
//                $defaultComments = null;
//                for ( $i = 0; $i < count(Comment::$valences); $i++ )
//                {
//                    $defaultComments[] = $this->elementDao->loadCommentByElementIdAndValence($element->getId(), $i)->getBody();
//                }
//                $stockComments[] = $defaultComments;
//            }
//        }
//
//        //send to page
//        Javascript::put(['stockComments' => $stockComments]);
//
//        $stockComments = json_encode($stockComments, JSON_FORCE_OBJECT);
//
//        return $stockComments;
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
//        //send to page
//        Javascript::put(['grades' => GradeFactory::gradeJson()]);
//
//        return GradeFactory::gradeJson();
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