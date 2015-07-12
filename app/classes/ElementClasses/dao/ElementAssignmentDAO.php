<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 12:53 PM
 */

namespace ElementClasses\dao;


class ElementAssignmentDAO
{

    /**
     * Loads the elements for a given question
     * @param \Exam $exam
     * @param \Question $question
     * @return \ElementAssignment[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_elements(\Exam $exam, \Question $question)
    {
        $e = array();
        $eq = \ElementQuery::create()->useElementAssignmentQuery()->filterByExam($exam)->filterByQuestion($question)->endUse()->find();
        foreach($eq as $j){
        array_push($e, $j);
    }
        return $e;
//        return \ElementAssignmentQuery::create()->filterByExam($exam)->filterByQuestion($question)->find();
    }

    public function load_by_exam(\Exam $exam)
    {
        $element_assign = \ElementAssignmentQuery::create()
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
        $eq = \ElementAssignmentQuery::create()->filterByExam($exam)->filterByQuestion($question)->findOneOrCreate();
        $eq->setElement($element);
        $eq->setSubtask($subtask);
        $eq->save();
        return $eq;
    }
}