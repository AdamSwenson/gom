<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 12:53 PM
 */

namespace App\classes\RequestHandlers\dao;


/**
 * Class ElementAssignmentDAO
 * Handles almost all database interactions with the elementsXquestions table
 *
 * @package App\classes\RequestHandlers\dao
 */
class ElementAssignmentDAO implements IElementAssignmentDAO
{


    function __construct()
    {
    }

    /**
     * Loads the elements for a given question
     * (returns an array of question objects)
     * @param $examId
     * @param $questionId
     */
    public function load_elements($examId, $questionId)
    {
//        $assignments = \ElementAssignmentQuery::create()
//            ->filterByUser($this->user)
//            ->filterByExam($exam)
//            ->filterByQuestion($question)
//            ->find();
//
//        $e = array();
//    return \ElementQuery::create()
//            ->filterByUser($this->user)
//                ->useElementAssignmentQuery()
//                    ->filterByExam($exam)
//                    ->filterByQuestion($question)
//                ->endUse()
//            ->find();
//        foreach ($assignments as $j)
//        {
//            array_push($e, $j);
//        }

//        return $e;
//        return \ElementAssignmentQuery::create()->filterByExam($exam)->filterByQuestion($question)->find();
    }

//    /**
//     *
//     * @param \Exam $exam
//     * @param \Question $question
//     */
//    public function load_element_assignments(\Exam $exam, \Question $question)
//    {
//
//    }

    public function load_by_exam($examId)
    {
//        $element_assign = \ElementAssignmentQuery::create()
//            ->filterByUser($this->user)
//            ->filterByExam($exam)
//                ->useQuestionQuery()
//                    ->useQuestionAssignerQuery()
//                        ->filterByExam($exam)
//                    ->endUse()->with('QuestionAssigner')
//                ->endUse()->with('Question')
//            ->find();
//
//        return $element_assign;
    }

    /**
     * Records new element assignment to question
     * @param $examId
     * @param $questionId
     * @param $elementId
     * @param $subtask
     * @return \ElementAssignment
     */
    public function record($examId, $questionId, $elementId, $subtask)
    {
//        $eq = \ElementAssignmentQuery::create()
//            ->filterByUser($this->user)
//            ->filterByExam($exam)
//            ->filterByQuestion($question)
//            ->filterBySubtask($subtask)
//            ->findOneOrCreate();
//        $eq->setElement($element);
////        $eq->setSubtask($subtask);
//        $eq->save();
//
//        return $eq;
    }
}
