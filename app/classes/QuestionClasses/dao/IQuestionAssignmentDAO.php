<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 10:59 AM
 */

namespace QuestionClasses\dao;


interface IQuestionAssignmentDAO
{

    /**
     * Loads and returns a question assignment
     * @param \Exam $exam
     * @param $question_number
     * @return \QuestionAssigner
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, $question_number);

    /**
     * @param \Exam $exam
     * @return \Propel\Runtime\Collection\ObjectCollection|\QuestionAssigner[]
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_for_exam(\Exam $exam);

    /**
     * @param \Exam $exam
     * @param \Question $question
     * @param $question_number
     * @throws \Propel\Runtime\Exception\PropelException
     * @return Boolean
     */
    function record(\Exam $exam, \Question $question, $question_number);

}