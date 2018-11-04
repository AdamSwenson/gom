<?php

namespace App\Http\Controllers\Grade;

use App\Comment;
use App\Grade;
use App\GradeAssignment;
use App\Http\Controllers\Controller;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use JavaScript;

/**
 * Used for setting the grade distribution cutoffs.
 * Versions:
 *      >= 0.2.0
 *
 * Class GradeAssignmentController
 * @package App\Http\Controllers\Grade
 */
class GradeAssignmentController extends Controller
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
    public function __construct( IExamRepository $IExamRepository,
                                 IElementRepository $elementRepository,
                                 IElementAssignmentRepository $elementAssignmentRepository,
                                 IElementScoreRepository $elementScoreRepository,
                                 IQuestionAssignmentRepository $questionAssignmentRepository,
                                 IQuestionScoreRepository $questionScoreRepository,
                                 IGradingTimeRepository $gradingTimeRepository,
                                 IStudentRepository $studentRepository,
                                 IGradeAssignmentRepository $gradeAssignmentRepository,
                                 IJsDataPreparation $jsonPrep )
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function assign( Exam $exam )
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $examId = $exam->getId();

        // get the max_scores and compute examMaxScore
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($examId);
        $examMaxScore = 0;

        foreach ( $questionAssignments as $assignment ) {
            $questionMax = $assignment->getQuestion()->getMaxScore();

            //If max question score not set, use the default max score
            if ( empty($questionMax) ) {
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
        foreach ( $students as $student ) {
            $questionItems = $this->questionScoreDao->load_for_student_on_exam($examId, $student->getId());
            // Don't include any students who haven't been graded
            if ( !$this->examGraded($questionItems) ) {
                continue;
            }

            $examScore = 0;
            foreach ( $questionItems as $score ) {
                if ( isset($score->questionScore) ) {
                    $examScore += $score->questionScore;
                }
            }
            $examScores[] = $examScore;
        }

        if ( empty($students) || empty($examScores) ) {
            return ('Either students or exam scores are empty');
        }

        return View::make('grade.grade_assign', [
            'exam' => $exam,
            'examScores' => $examScores,
            'examMaxScore' => $examMaxScore,
            'gradeTypes' => $gradeTypes,
            'gradeCutoffs' => $gradeCutoffs,
        ]);
    }

    /**
     * @param $questionItems
     * @return bool
     */
    protected function examGraded( $questionItems )
    {
        $graded = false;
        foreach ( $questionItems as $questionItem ) {
            if ( $questionItem->questionScore != null ) {
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function getGradeCutoffs( Exam $exam, $examMaxScore )
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $gradeCutoffs = $this->gradeAssignmentDao->load_grade_min_scores_for_exam($exam);

        // if gradecutoffs aren't set, calculate them...
        if ( empty($gradeCutoffs) ) {
            $gradeCutoffs = [];
            foreach ( GradeFactory::getDefaultCutoffsOfGrades() as $val ) {
                // allow decimals if the exam has a very low maximum grade
                if ( $examMaxScore < 25 ) {
                    $decRound = 1;
                } else {
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function recordAssignments( Exam $exam, GradeAssignmentRequest $request )
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        //This will hold the incoming assignments after they have been processed and before they are written to the db
        $assignments = [];
        //This will hold the grades which are not being assigned and slated for deletion if they were in the db
        $nonAssigned = [];

        try {
            //Pull out each value to assign, make a grade object and push into $assignments
            for ( $i = 0; $i <= 12; $i++ ) {
                //Check that the field has a value. If just try checking the value, may
                //run into trouble with empty(0) for F grade.
                if ( $request->has(self::GRADE_ASSIGNMENT_FIELD_BASE . $i) ) {
                    $grade = GradeFactory::loadByOrder($i);
                    $minScore = $request->input(self::GRADE_ASSIGNMENT_FIELD_BASE . $i);
                    //push into array to be recorded
                    $assignments[] = ['minScore' => $minScore, 'grade' => $grade];
                } else {
                    //If a letter grade was not assigned, make note so any preexisting value can be removed
                    $nonAssigned[] = $i;
                }
            }

            //Request validator already checked for consistency, so let's write to the db
            foreach ( $assignments as $assign ) {
                $this->gradeAssignmentDao->record_grade_assignment($exam, $assign['grade'], $assign['minScore']);
            }

            //Delete any pre-existing grades which were not assigned on this request
            if ( !empty($nonAssigned) ) {
                foreach ( $nonAssigned as $naOrder ) {
                    $grade = GradeFactory::loadByOrder($naOrder);
                    $this->gradeAssignmentDao->delete_grade_assignment($exam, $grade);
                }
            }

            flash()->success('Grade assignments have been recorded');

        } catch (\Exception $e) {
            Log::error('Problem recording grade assignments ' . $e->getMessage());

            flash()->error('There was a problem recording the grade assignments. Please try again. If the problem persists, please let us know');
        }

        return redirect()->action('GradeController@index');
    }


    // =================================== New gom

    /**
     * Returns all grade assignments for the exam
     * If no assignments exist, it creates them with
     * default values based on the maximum possible score on the
     * exam
     *
     * @version >= 0.2.0
     * @param Exam $exam
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function show( Exam $exam )
    {
        // create standard grades if none exist in the db
        if ( Grade::all()->count() === 0 ) GradeFactory::initializeStandardGrades();

        $assignments = GradeAssignment::where('exam_id', $exam->id)->get();

        //If we have some assignments, then we just return them
        if ( is_null($assignments) || sizeof($assignments) === 0 ) {
            //Otherwise we need to initialize them
            //This will give it default values based on the max possible score,
            GradeAssignment::initializeOnExam($exam, true);
        }
//        $out = [];
//        return GradeAssignment::where('exam_id', $exam->id)->with('grade')->get();

//        foreach (GradeAssignment::where('exam_id', $exam->id)->with('grade')->get() as $assign){
//            //we want to flatten the grade object properties
//            //into the grade assignment properties
//            $out[] =  collect($assign->toJson())->flatten();
//        }
//        return $out;


        $out = [];
        foreach ( GradeAssignment::where('exam_id', $exam->id)->with('grade')->get() as $assign ) {
            $out[] = [
                'id' => $assign->id,
                'calcValue' => $assign->grade->calc_value,
                'displayValue' => $assign->grade->display_value,
                'gradeId' => $assign->grade->id,
                'group' => $assign->grade->group,
                'minScore' => $assign->min_score,
                'ordinal' => $assign->grade->ordinal
            ];
        }
        return $out;


    }


    /**
     * Updates the grade assignment
     * @param GradeAssignment $assignment
     * @param Request $assignmentRequest
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function update( GradeAssignment $assignment, Request $assignmentRequest )
    {
        $assignment->update(['min_score' => $assignmentRequest->input('min_score')]);
//        $assignment->save();

        return $this->sendAjaxSuccess();
    }

}