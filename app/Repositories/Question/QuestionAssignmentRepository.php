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
    public function load($examId, $question_number)
    {
        return QuestionAssignment::onExam($examId)->questionNumber($question_number)->firstOrFail();
    }

    /**
     * Returns the integer number that the question is on the exam
     * @param $examId
     * @param $questionId
     * @return mixed
     */
    public function loadQuestionNumberById($examId, $questionId)
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
    public function record($examId, $questionId, $question_number)
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
     * @return
     *
     */
    public function load_all_for_exam($examId)
    {
        return QuestionAssignment::onExam($examId)->orderBy('question_number')->get();
    }

    /**
     * Removes the assignment of a question to an exam
     * @param $examId
     * @param $questionId
     * @return mixed
     */
    function remove($examId, $questionId)
    {
        $qa = QuestionAssignment::onExam($examId)->onQuestionId($questionId)->firstOrFail();

        return $qa->delete();
    }

    /* ------------------------------------------------------------------------------------------------- */
    public function updateAll(Exam $exam, QuestionRequest $request)
    {
        $this->exam = $exam;

        //Load and update question objects or make new ones. Hold in the questions array
        $this->makeAndLoad($request);

        //Load array of questionIds currently used in question assignments for the exam
        $this->getExistingQuestionIds($exam->getId());


        //Record assignments
        $this->helper = new AssignmentHelper();

//        $case = $this->helper->determineCase($this->existingIds, $this->requestIds);
//dd([$case, $this->existingIds, $this->requestIds]);

        switch ($this->helper->determineCase($this->existingIds, $this->requestIds))
        {
            case AssignmentHelper::CASE_NO_CHANGE:
                //do nothing
                break;
            case AssignmentHelper::CASE_PURE_DELETION:
                //delete all the existing assignments (should cascade to delete scores)
                $this->deleteQuestions();
//                foreach ($this->existingIds as $id)
//                {
//                    //this should've already been handled by deletion
//                    $this->remove($exam->getId(), $id);
//                }
                break;
            case AssignmentHelper::CASE_PURE_ADDITION:
                //add new assignments (no effect on scores)
                foreach ($this->questions as $q)
                {
                    $this->record($exam->getId(), $q[1]->getId(), $q[0]);
                }
                break;

            case AssignmentHelper::CASE_IMPURE:
                //Some potentially confusing mix of additions, deletions, and reordering has happened
                $this->handleImpure();
                break;

//            case AssignmentHelper::CASE_REPLACEMENT:
//                //delete any changed assignments (should cascade to delete scores)
//                break;
//            case AssignmentHelper::CASE_SHUFFLE:
//                //Change the subtask or question number fields in the assignment table.
//                //Should not affect scores.
//                foreach ($this->helper->changedItems as $item)
//                {
//                    //TODO This should be done via a transaction
//                    $questionNumber = $item['order'] + 1;
//                    $assign = QuestionAssignment::where('exam_id', $exam->getId())
//                        ->where('question_number', $questionNumber)
//                        ->where('question_id', $item['existingId'])
//                        ->first();
//                    $assign->question_id = $item['requestId'];
//                    $assign->update();
//                }
//                break;
        }

    }

    /**
     * Deletes any questions (not just their assignments) which
     * are in the list of deletedIds on the helper
     */
    public function deleteQuestions()
    {
        if (count($this->helper->deletedIds) > 0)
        {
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
        if( !empty($this->exam))
        {
            /*
             * This all needs to be inside the transaction. If, for example, it fails before the cleanup step,
             * the user will be very confused by having questions 6-10 when she thought she had 1-5.
             */
            DB::transaction(function ()
            {

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
                foreach ($this->requestIds as $id)
                {
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
                for ($i = 0; $i < count($assigns); $i++)
                {
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
    public function getMaxQuestionNumber($examId)
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
    public function getExistingQuestionIds($examId)
    {
        $query = <<<MYSQL
            SELECT question_id
            FROM question_assignments
            WHERE exam_id = :examId
            ORDER BY question_number
MYSQL;
        $values = ['examId' => $examId];
        foreach (\DB::select($query, $values) as $obj)
        {
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
    public function makeAndLoad(QuestionRequest $request)
    {
        $questionDao = app()->make('App\Repositories\Question\IQuestionRepository');
        $i = 1;
        while ($request->input('questionName' . $i))
        {
            // new questions arrive with id == 0
            if (($request->input('questionId' . $i)) == 0)
            {
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