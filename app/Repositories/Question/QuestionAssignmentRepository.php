<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 5:24 PM
 */

namespace App\Repositories\Question;

use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\SecurityClasses\cleaning\ICleanerFactory;
use App\Exam;
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


    /** @var CleanerFactory  */
    public $cleaner;

    public function __construct()
    {
        $this->cleaner = new CleanerFactory();
    }
//    /**
//     * @param ICleanerFactory $cleaner
//     */
//    public function __construct(ICleanerFactory $cleaner)
//    {
//        $this->cleaner = $cleaner;
//    }


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
    public function loadByIds($examId, $questionId)
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
     * @return QuestionAssignment
     */
    public function record($examId, $questionId, $question_number)
    {
        $q = Question::find($questionId);
        $q->setQuestionNumber($examId, $question_number);
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
}