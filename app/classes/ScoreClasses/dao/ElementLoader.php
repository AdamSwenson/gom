<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/6/15
 * Time: 12:15 PM
 */

namespace App\classes\ScoreClasses\dao;


use App\classes\Traits\UserTraits;

class ElementLoader extends LoaderParent implements ILoader
{

    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }
    static public $type = ScoreDAO::WORKER_ELEMENT;

    public function all()
    {
        if(isset($this->student)){
            return $this->get_all_element_scores_for_student();
        }else{
            return $this->get_all_element_scores_for_exam();
        }
    }

    /**
     * @param $object \Question|\Element A \Question or \Element with its id set
     * @return mixed Array of ElementScore objects or single ElementScore object
     */
    public function object($object)
    {
        if(isset($this->student)){
             return  \ElementScoreQuery::create()
                 ->filterByUser($this->user)
                ->filterByExam($this->exam)
                ->filterByStudent($this->student)
                ->filterByElement($object)
                ->findOne();
        }else{
            return  \ElementScoreQuery::create()
                ->filterByUser($this->user)
                ->filterByExam($this->exam)
                ->filterByElement($object)
                ->find();
        }
    }

    /**
     * @param $questionNumber Int
     * @return mixed
     */
    public function question_number($questionNumber)
    {
        try {
            $scores = array();
            $q = \QuestionAssignerQuery::create()
                ->filterByUser($this->user)
                ->filterByExam($this->exam)
                ->filterByQuestionnumber($questionNumber)
                ->findOne();
            if(!$q){
                throw new \Exception();
            }
            $el_assigns = \ElementAssignmentQuery::create()
                ->filterByUser($this->user)
                ->filterByExam($this->exam)
                ->filterByQuestion($q->getQuestion())
                ->orderBySubtask()
                ->find();
            if(!$el_assigns){
                throw new \Exception();
            }
            foreach ($el_assigns as $ea) {
                $el = $ea->getElement();
                $es = isset($this->student) ? $this->get_one_with_student($el) : $this->get_one_no_student($el);
                if(!$es)
                {throw new \Exception();}
                array_push($scores, $es);
            }
            return $scores;
        }catch(\Exception $e){}
    }

    protected function get_one_with_student(\Element $element)
    {
        return  \ElementScoreQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($this->exam)
            ->filterByStudent($this->student)
            ->filterByElement($element)
            ->findOne();
    }

    protected function get_one_no_student(\Element $element)
    {
        return  \ElementScoreQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($this->exam)
            ->filterByElement($element)
            ->findOne();
    }

    /**
     * Gets one student's scores on all elements for one exam
     */
    protected function get_all_element_scores_for_student()
    {
        return  \ElementScoreQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($this->exam)
            ->filterByStudent($this->student)
            ->find();
    }

    /**
     * Gets scores for all elements for all students on one exam
     */
    protected function get_all_element_scores_for_exam()
    {
        return  \ElementScoreQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($this->exam)
            ->find();
    }
}