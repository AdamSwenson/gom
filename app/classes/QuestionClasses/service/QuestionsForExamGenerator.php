<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/15
 * Time: 5:04 PM
 */

namespace App\classes\QuestionClasses\service;

/**
 * Class QuestionsForExamGenerator
 * Generator for getting all questions associated with an exam
 *
 * @package App\classes\QuestionClasses\service
 */
class QuestionsForExamGenerator
{


    /**
     * Returns a generator object with each question assigned to the exam
     * @param \Exam $exam
     * @return \Generator
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function __invoke(\Exam $exam)
    {
        $questionAssignments = \QuestionAssignerQuery::create()
            ->filterByExam($exam)
            ->find();
        foreach ($questionAssignments as $qa) {
            $q = $qa->getQuestion();
            yield $q;
        }
    }
}