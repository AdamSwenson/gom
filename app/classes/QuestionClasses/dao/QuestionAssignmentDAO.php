<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 1:11 PM
 */

namespace App\classes\QuestionClasses\dao;



class QuestionAssignmentDAO implements IQuestionAssignmentDAO
{

    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }

    /**
     * Loads and returns a question assignment
     * @param \Exam $exam
     * @param $question_number
     * @return \QuestionAssigner
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, $question_number)
    {
        return \QuestionAssignerQuery::create()->filterByExam($exam)->filterByQuestionnumber($question_number)->findOne();
    }

    /**
     * Gets questions for exam, ordered by question number
     * @param \Exam $exam
     * @return \Propel\Runtime\Collection\ObjectCollection|\QuestionAssigner[]
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_for_exam(\Exam $exam)
    {
        return \QuestionAssignerQuery::create()
            ->filterByExam($exam)
            ->orderByQuestionnumber()
            ->find();
    }

    /**
     * @param \Exam $exam
     * @param \Question $question
     * @param $question_number
     * @throws \Propel\Runtime\Exception\PropelException
     * @return Boolean
     */
    public function record(\Exam $exam, \Question $question, $question_number)
    {
        $q_assign = \QuestionAssignerQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($exam)
            ->filterByQuestionnumber($question_number)
            ->findOneOrCreate();
        $q_assign->setQuestion($question);
        return $q_assign->save();
    }
}