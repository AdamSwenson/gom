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

/**
 * Class QuestionAssignmentRepository
 *
 * Replaces questionAssignmentDao
 *
 * @package Repositories\Question
 */
class QuestionAssignmentRepository implements IQuestionAssignmentRepository
{

    /** @var \App\HTTP\Controllers\helpers\cleaning\ICleanerFactory */
    public $cleaner;

    protected $questions = [];

    protected $requestIds = [];

    protected $existingIds = [];

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
//
//        $qa = QuestionAssignment::where('exam_id', $examId)->where('question_number', $question_number)->first();
////        $qa = QuestionAssignment::firstOrNew(['exam_id' => $examId, 'question_number' => $question_number]);
//        if(empty($qa)){
//            $qa = new QuestionAssignment();
//            $qa->exam_id = $examId;
//            //$qa->exam()->attach($examId);
//        }
////        $qa->question()->attach($questionId);
//        $qa->question_id = $questionId;
//        $qa->save();
//        return $qa;
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
        //Load and update question objects or make new ones. Hold in the questions array
        $this->makeAndLoad($request);

        //Load array of questionIds currently used in question assignments for the exam
        $existing = $this->load_all_for_exam($exam->getId());
        foreach($existing as $e)
        {
            $this->existingIds[] = $e->getId();
        }

        //Record assignments
        $helper = new AssignmentHelper();

        switch ($helper->determineCase($this->existingIds, $this->requestIds))
        {
            case AssignmentHelper::CASE_NO_CHANGE:
                //do nothing
                break;
            case AssignmentHelper::CASE_PURE_DELETION:
                //delete all the existing assignments (should cascade to delete scores)
                foreach($this->existingIds as $id)
                {
                    $this->remove($exam->getId(), $id);
                }

                break;
            case AssignmentHelper::CASE_PURE_ADDITION:
                //add new assignments (no effect on scores)
                foreach($this->questions as $q)
                {
                    $this->record($exam->getId(), $q[1]->getId(), $q[0]);
                }
                break;
            case AssignmentHelper::CASE_REPLACEMENT:
                //delete any changed assignments (should cascade to delete scores)
                break;
            case AssignmentHelper::CASE_SHUFFLE:
                //Change the subtask or question number fields in the assignment table.
                //Should not affect scores.
                foreach($helper->changedItems as $item)
                {
                    //TODO This should be done via a transaction
                    $questionNumber = $item['order'] + 1;
                    $assign = QuestionAssignment::where('exam_id', $exam->getId())
                        ->where('question_number', $questionNumber)
                        ->where('question_id', $item['existingId'])
                        ->first();
                    $assign->question_id = $item['requestId'];
                    $assign->update();
                }
            break;
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