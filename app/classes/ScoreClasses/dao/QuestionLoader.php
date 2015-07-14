<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/6/15
 * Time: 12:15 PM
 */

namespace App\classes\ScoreClasses\dao;


use App\classes\ScoreClasses\dao\ScoreDAO;

class QuestionLoader extends LoaderParent implements ILoader
{
    static public $type = ScoreDAO::WORKER_QUESTION;


    public function all()
    {
        if(isset($this->student)){
            return $this->get_all_scores_for_student();
        }
        else{
            return $this->get_all_scores_on_exam();
        }
    }

    /**
     * @param $object Either a \Question or \Element with its id set
     * @return mixed
     */
    public function object($object)
    {
        if(isset($this->student)){
            return $this->get_all_students_on_one_question($object);
        }
        else{
            return $this->get_all_students_on_one_question($object);
        }
    }

    /**
     * @param $questionNumber Int
     * @return mixed
     */
    public function question_number($questionNumber)
    {
        if(isset($this->student)){
            return $this->get_student_scores_by_question_number($questionNumber);
        }
        else{
            return $this->get_all_scores_by_question_number($questionNumber);
        }
    }


    /**
     * Gets all question scores for one student on one exam
     * @return \Propel\Runtime\Collection\ObjectCollection|\QuestionScore[]
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function get_all_scores_for_student()
    {
        return  \QuestionScoreQuery::create()
            ->filterByExam($this->exam)
            ->filterByStudent($this->student)
            ->find();
    }

    /**
     * Get scores for all students on all questions on one exam
     */
    protected function get_all_scores_on_exam()
    {
        return  \QuestionScoreQuery::create()
            ->filterByExam($this->exam)
            ->find();
    }

    /**
     * Get one student's score on one exam question
     * @param \Question $question
     * @return \QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function get_student_score_on_one_question(\Question $question)
    {
        return  \QuestionScoreQuery::create()
            ->filterByExam($this->exam)
            ->filterByStudent($this->student)
            ->filterByQuestion($question)
            ->findOne();
    }

    /**
     * Get all student scores for one question on one exam
     * @param \Question $question
     * @return \Propel\Runtime\Collection\ObjectCollection|\QuestionScore[]
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function get_all_students_on_one_question(\Question $question)
    {
        return  \QuestionScoreQuery::create()
            ->filterByExam($this->exam)
            ->filterByQuestion($question)
            ->find();
    }

    /**
     * Gets all of one student's scores for one question
     * @param $questionNumber
     * @return \QuestionScore
     */
    protected function get_student_scores_by_question_number($questionNumber)
    {
        try {
            $q = \QuestionAssignerQuery::create()
                ->filterByExam($this->exam)
                ->filterByQuestionnumber($questionNumber)
                ->findOne();
            if(!$q){
                throw new \Exception();
            }
            return  \QuestionScoreQuery::create()
                ->filterByExam($this->exam)
                ->filterByStudent($this->student)
                ->filterByQuestion($q->getQuestion())
                ->findOne();
        }catch(\Exception $e){}
    }

    /**
     * Gets all scores on one exam for one question
     * Note: Assume that exam is set. Hard to imagine the use case for getting all scores
     * by question number across exams.
     * @param $questionNumber
     * @return \Propel\Runtime\Collection\ObjectCollection|\QuestionScore[]
     */
    protected function get_all_scores_by_question_number($questionNumber)
    {
        try {
            $q = \QuestionAssignerQuery::create()
                ->filterByExam($this->exam)
                ->filterByQuestionnumber($questionNumber)
                ->findOne();
            if(!$q){
                throw new \Exception();
            }
            return  \QuestionScoreQuery::create()
                ->filterByExam($this->exam)
                ->filterByQuestion($q->getQuestion())
                ->find();
        }catch(\Exception $e){}
    }

}