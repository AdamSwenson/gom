<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 5:24 PM
 */

namespace App\Repositories\Question;


use App\Exam;
use App\Http\Controllers\helpers\assignments\AssignmentHelper;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\Request;
use App\Question;
use App\QuestionAssignment;
use Illuminate\Support\Facades\DB;

/**
 * Class QuestionAssignmentRepository
 *
 * Replaces questionAssignmentDao
 *
 * @package Repositories\Question
 */
class QuestionAssignmentRepository implements IQuestionAssignmentRepository
{
    /** @var  Exam Holds the exam working on */
    public $exam;

    /** @var \App\HTTP\Controllers\helpers\cleaning\ICleanerFactory */
    public $cleaner;

    protected $questions = [];

    protected $requestIds = [];

    protected $existingIds = [];

    /** @var  \App\Http\Controllers\helpers\assignments\IAssignmentHelper */
    protected $helper;

    public function __construct()
    {
        $this->cleaner = app()->make('App\HTTP\Controllers\helpers\cleaning\ICleanerFactory');

    }


    /**
     * Loads and returns a question assignment
     * TODO: Add eager loading of question
     *
     * @param $examId
     * @param $question_number
     * @return QuestionAssignment
     */
    public function load( $examId, $question_number )
    {
        return QuestionAssignment::onExam($examId)->questionNumber($question_number)->firstOrFail();
    }

    /**
     * Returns the integer number that the question is on the exam
     * @param $examId
     * @param $questionId
     * @return mixed
     */
    public function loadQuestionNumberById( $examId, $questionId )
    {
        $q = Question::findOrFail($questionId);
        $questionNumber = $q->getQuestionNumber($examId);

        return $questionNumber;
        //   return QuestionAssignment::where('exam_id', $examId)->where('question_id', $questionId)->firstOrFail();
//        return QuestionAssignment::onExam($examId)->onQuestionId($questionId)->firstOrFail();
    }

    /**
     * Assigns a question to an exam as the specified question number
     *
     * @param integer $examId
     * @param integer $questionId
     * @param integer $question_number
     * @return Question
     */
    public function record( $examId, $questionId, $question_number )
    {
        $q = Question::findOrFail($questionId);
        $q->setQuestionNumber($examId, $question_number);
        return $q;
    }

    /**
     * Gets questions for exam, ordered by question number
     * Returns a collection of QuestionAssignment objects.
     * TODO: Add eager loading of question
     *
     * @param $examId
     * @return QuestionAssignment
     */
    public function load_all_for_exam( $examId )
    {
        return QuestionAssignment::onExam($examId)->orderBy('question_number')->get();
    }

    /**
     * Removes the assignment of a question to an exam
     * @param integer $examId
     * @param integer $questionId
     * @return mixed
     */
    function remove( $examId, $questionId )
    {
        $qa = QuestionAssignment::onExam($examId)->onQuestionId($questionId)->firstOrFail();
        return $qa->delete();
    }

    /* ------------------------------------------------------------------------------------------------- */
    /**
     * Handles all operations required by calls to QuestionController->updateAll
     * It was necessary to do it all here because we cannot just update the question
     * assignments one by one without causing trouble with preexisting scores.
     *
     * @param Exam $exam
     * @param QuestionRequest $request
     * @throws \Exception
     */
    public function updateAll( Exam $exam, Request $request )
    {
        $this->exam = $exam;

        //Load and update question objects or make new ones. Hold in the questions array
        $this->makeAndLoad($request);

        //Load array of questionIds currently used in question assignments for the exam
        $this->getExistingQuestionIds($exam->getId());

        return $this->handleAssignmentUpdate($exam, $this->existingIds, $this->requestIds, $this->questions);

    }

    public function updateItemOrder( $exam, $order )
    {
        $this->exam = $exam;

        //Load array of questionIds currently used in question assignments for the exam
        $this->getExistingQuestionIds($exam->getId());
$this->requestIds = $order;
        $this->helper = app()->make('App\Http\Controllers\helpers\assignments\IAssignmentHelper');

        switch ( $this->helper->determineCase($this->existingIds, $order) ) {
            case AssignmentHelper::CASE_NO_CHANGE:
                //do nothing
                break;

            case AssignmentHelper::CASE_PURE_DELETION:
                //delete all the existing assignments (should cascade to delete scores)
                $this->deleteQuestions();
                break;

            case AssignmentHelper::CASE_PURE_ADDITION:
                //load the as yet unassociated questions
                $questions = Question::findMany($this->helper->newIds);
                //add new assignments (no effect on scores)
                foreach ( $questions as $q ) {
                    $this->record($exam->getId(), $q[1]->getId(), $q[0]);
                }
                break;

            case AssignmentHelper::CASE_IMPURE:
                //Some potentially confusing mix of additions, deletions, and reordering has happened
                $this->handleImpure();
                break;

            default:
                throw new \Exception('Case not covered by assignmentHelper');
        }

        $this->getExistingQuestionIds($exam->getId());

        return $this->existingIds;



    }

    /**
     * Deletes any questions (not just their assignments) which
     * are in the list of deletedIds on the helper
     */
    public function deleteQuestions()
    {
        if ( count($this->helper->deletedIds) > 0 ) {
            Question::destroy($this->helper->deletedIds);
        }
    }

    /**
     * There are a bunch of possible combinations of addition, deletion, and reordering which
     * might have happened. We can't change the assignment ids for existing assignments because
     * we will lose the associated scores. This handles those cases.
     */
    public function handleImpure()
    {
        if ( !empty($this->exam) && !empty($this->requestIds) ) {
            /*
             * This all needs to be inside the transaction. If, for example, it fails before the cleanup step,
             * the user will be very confused by having questions 6-10 when she thought she had 1-5.
             */
            DB::transaction(function () {

                /* If a question was deleted, no need for fancy assignment nonsense. Just delete
                   that bad boy and let it cascade to assignments and scores.*/
                $this->deleteQuestions();

                //Get the highest question number that has been used on the exam
                $newSort = $this->getMaxQuestionNumber($this->exam->getId());

                /* There are a bunch of possible combinations of addition, deletion, and reordering which
                   might have happened. We can't change the assignment ids for existing assignments because
                   we will lose the associated scores. So we're going to temporarily assign each question a question number
                   that is higher than any existing score (we will insert new questions and update the question_number of
                   already assigned questions).*/
                foreach ( $this->requestIds as $id ) {
                    //this is the ordinal value which temporarily replaces the question number
                    $newSort += 1;
                    $query = <<<MYSQL
             INSERT INTO question_assignments (question_id, exam_id, question_number, created_at, updated_at)
            VALUES (:questionId, :examId, :questionNumber, NOW(), NOW())
            ON DUPLICATE KEY UPDATE question_number = :questionNumber2, updated_at = NOW();
MYSQL;
                    $values = [
                        'examId' => $this->exam->getId(),
                        'questionId' => $id,
                        'questionNumber' => $newSort,
                        'questionNumber2' => $newSort
                    ];
                    DB::update($query, $values);
                }

                /*
                 * Now that all the questions are in order in the question_assignments table, we need to
                 * give them the correct question numbers (i.e., so that the order starts at 1).
                 *
                 * So we load all question assignments for the exam and then update their question_numbers
                 * accordingly.
                 *
                 * In case you're wondering, we could've avoided that last step by making question_number into just an ordinal value
                 * and have logic elsewhere translate the ordinal into the question number the user expects. However, since
                 * question number can be relevant in lots of places (especially in calculating statistics which we might want to
                 * do via joins or directly on the database), it is much cleaner just to save it in the db. Hence the extra step.
                 */
                $assigns = QuestionAssignment::where('exam_id', $this->exam->getId())->orderBy('question_number')->get();
                for ( $i = 0; $i < count($assigns); $i++ ) {
                    $assigns[$i]->question_number = $i + 1;
                    $assigns[$i]->update();
                }
            });
        }
    }

    /**
     * Loads the highest question_number that has been assigned on the exam.
     *
     * @param integer $examId
     * @return integer mixed
     */
    public function getMaxQuestionNumber( $examId )
    {
        $query = <<<MYSQL
            SELECT MAX(question_number) AS max
            FROM question_assignments
            WHERE exam_id = :examId
MYSQL;
        $values = ['examId' => $examId];
        $result = \DB::select($query, $values);

        return $result[0]->max;
    }

    /**
     * Retrieves ths questionIds for questions that have already been
     * assigned on this exam and stores them in $this->existingIds
     * @param integer $examId
     */
    public function getExistingQuestionIds( $examId )
    {
        //clear out the current list
        $this->existingIds = [];

        $query = <<<MYSQL
            SELECT question_id
            FROM question_assignments
            WHERE exam_id = :examId
            ORDER BY question_number
MYSQL;
        $values = ['examId' => $examId];
        foreach ( \DB::select($query, $values) as $obj ) {
            $this->existingIds[] = $obj->question_id;
        }
    }

    /**
     * Processes the request and makes new questions if the id is 0 and
     * loads existing questions.
     *
     * Stores all the questions in the questions array as
     * an array with the form: [questionNumber, questionObject].
     *
     * Also stores all ids from the incoming request (including newly created questions) in
     * ascending order of questionNumber (starting at 1) in $requestIds.
     *
     * @param QuestionRequest $request
     */
    public function makeAndLoad( Request $request )
    {
        $questionDao = app()->make('App\Repositories\Question\IQuestionRepository');
        $i = 1;
        if ( $request->has('requestVersion') && $request->input('requestVersion') >= 1 ) {
            //the request comes from the new style setup
            while ($request->input('index')) {
                if ( $request->has('id') && $request->input('id') == -1 ) {

                    $question = $questionDao->createQuestion(
                        $request->input('name'),
                        $request->input('text'),
                        $request->input('maxScore'));
                } else // other items already exist and should be updated
                {
                    $question = $questionDao->updateQuestion(
                        $request->input('id'),
                        $request->input('name'),
                        $request->input('text'),
                        $request->input('maxScore'));
                }
                //Store the question and its order for assignment
                $this->questions[] = [$i, $question];
                //Store the id of the question
                $this->requestIds[] = $question->getId();
                $i++;
            }

        } else {


            while ($request->input('questionName' . $i)) {
                // new questions arrive with id == 0
                if ( ($request->input('questionId' . $i)) == 0 ) {
                    $question = $questionDao->createQuestion(
                        $request->input('questionName' . $i),
                        $request->input('questionText' . $i),
                        $request->input('maxScore' . $i));

                } else // other items already exist and should be updated
                {
                    $question = $questionDao->updateQuestion(
                        $request->input('questionId' . $i),
                        $request->input('questionName' . $i),
                        $request->input('questionText' . $i),
                        $request->input('maxScore' . $i));
                }
                //Store the question and its order for assignment
                $this->questions[] = [$i, $question];
                //Store the id of the question
                $this->requestIds[] = $question->getId();
                $i++;
            }
        }
    }

    /**
     * @param Exam $exam
     * @throws \Exception
     */
    protected function handleAssignmentUpdate( Exam $exam, $existingIds, $requestIds, $questions )
    {
        //Record assignments
        $this->helper = app()->make('App\Http\Controllers\helpers\assignments\IAssignmentHelper');

        switch ( $this->helper->determineCase($existingIds, $requestIds) ) {
            case AssignmentHelper::CASE_NO_CHANGE:
                //do nothing
                break;

            case AssignmentHelper::CASE_PURE_DELETION:
                //delete all the existing assignments (should cascade to delete scores)
                $this->deleteQuestions();
                break;

            case AssignmentHelper::CASE_PURE_ADDITION:
                //add new assignments (no effect on scores)
                foreach ( $questions as $q ) {
                    $this->record($exam->getId(), $q[1]->getId(), $q[0]);
                }
                break;

            case AssignmentHelper::CASE_IMPURE:
                //Some potentially confusing mix of additions, deletions, and reordering has happened
                $this->handleImpure();
                break;

            default:
                throw new \Exception('Case not covered by assignmentHelper');
        }
    }

}