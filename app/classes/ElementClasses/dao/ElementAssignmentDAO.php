<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 12:53 PM
 */

namespace App\classes\ElementClasses\dao;


use App\classes\Traits\UserTraits;

class ElementAssignmentDAO
{
use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }

    /**
     * Loads the elements for a given question
     * (returns an array of question objects)
     * @param \Exam $exam
     * @param \Question $question
     * @return \ElementAssignment[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_elements(\Exam $exam, \Question $question)
    {
        $assignments = \ElementAssignmentQuery::create()->filterByUser($this->user)
            ->filterByExam($exam)
            ->filterByQuestion($question)
            ->find();

        $e = array();
//        $eq = \ElementQuery::create()
//            ->filterByUser($this->user)
//            ->useElementAssignmentQuery();
//            ->filterByExam($exam)
//            ->filterByQuestion($question)
//            ->endUse()
//            ->find();
        foreach($assignments as $j){
        array_push($e, $j);
    }
        return $e;
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

    public function load_by_exam(\Exam $exam)
    {
        $element_assign = \ElementAssignmentQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($exam)
                ->useQuestionQuery()
                    ->useQuestionAssignerQuery()
                        ->filterByExam($exam)
                    ->endUse()->with('QuestionAssigner')
                ->endUse()->with('Question')
            ->find();
        return $element_assign;
    }

    /**
     * Records new element assignment to question
     * @param \Exam $exam
     * @param \Question $question
     * @param \Element $element
     * @return \ElementAssignment
     */
    public function record(\Exam $exam, \Question $question, \Element $element, $subtask)
    {
        $eq = \ElementAssignmentQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($exam)
            ->filterByQuestion($question)
            ->filterBySubtask($subtask)
            ->findOneOrCreate();
        $eq->setElement($element);
//        $eq->setSubtask($subtask);
        $eq->save();
        return $eq;
    }
}
