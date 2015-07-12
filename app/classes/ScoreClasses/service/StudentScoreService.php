<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace ScoreClasses\service;

/**
 * Handles getting a student's scores for the output page
 *
 * @author adam
 */
class StudentScoreService
{
    public $data_access;

    public $question_scores = array();

    public $element_scores = array();

    public $comments;
    public $question_assigns;

    protected $student;

    protected $exam;

    /** @var  \JsonOutputClasses\encoders\IJsonOutput */
    public $encoder;

public $dao;
    /**
     * @param \JsonOutputClasses\encoders\IJsonOutput $encoder
     */
    public function setEncoder(\JsonOutputClasses\encoders\IJsonOutput $encoder)
    {
        $this->encoder = $encoder;
    }

    public function set_dao(\ScoreClasses\dao\IScoreDAO $dao)
    {
        $this->dao = $dao;
    }

    /**
     * Sets the data access object which does the actual querying etc
     * @param \ScoreClasses\IOutputScoreDAO
     */
    public function set_data_access(\ScoreClasses\IOutputScoreDAO $data_access)
    {
        $this->data_access = $data_access;
    }

    public function load_question_assignments()
    {
        $this->question_assigns = \QuestionAssignerQuery::create()
            ->filterByExam($this->exam)
            ->orderByQuestionnumber()
            ->find();
    }

    /**
     * Gets all questions scores for the student and stores in self::question_scores
     * @param \OutputClasses\facades\IVisitor $visitor
     */
    public function get_question_scores(\OutputClasses\facades\IVisitor $visitor)
    {
        $this->load_objects($visitor);

        $this->dao->setExam($this->exam);
        $this->dao->setStudent($this->student);
        $results = $this->dao->load('question', 'all');

//        $results = $this->data_access->all_question_scores($this->exam, $this->student);
        foreach ($results as $r) {
            $qa = \QuestionAssignerQuery::create()->filterByExam($this->exam)->filterByQuestion($r->getQuestion())->findOne();
            $ar = array(
                'questionID' => $r->getQuestion()->getId(),
                'questionScore' => $r->getQuestionscore(),
                'questionName' => $r->getQuestion()->getQuestionname(),
                'questionNumber'=> $qa->getQuestionnumber()
            );
            array_push($this->question_scores, $ar);
        }
    }

    /**
     * Retrieves scores for a particular question and stores in self::question_scores
     * @param \OutputClasses\facades\IVisitor $visitor
     * @param \Question $question
     */
    public function get_particular_question_score(\OutputClasses\facades\IVisitor $visitor, \Question $question)
    {
        $this->load_objects($visitor);
        $this->dao->setExam($this->exam);
        $this->dao->setStudent($this->student);
        $this->question_scores = $this->dao->load('question', $question);
//        $this->question_scores = $this->data_access->particular_question_score($this->exam, $this->student, $question);
    }

    /**
     * Retrieves scores for all elements and stores in self::element_scores
     * JS will be expecting to do the following on the output json:
     * var el = new Element(v['elementID']);
     * el.setQuestionNumber(v['questionNumber']);
     * el.setElementAbbr(v['elementName']);
     * el.setElementEnglish(v['displayText']);
     * el.setScore(v['elementScore']);
     * el.setSubtask(v['subtask']);
     *
     * @param \OutputClasses\facades\IVisitor $visitor
     */
    public function get_element_scores(\OutputClasses\facades\IVisitor $visitor)
    {
        $this->load_objects($visitor);
        $this->dao->setExam($this->exam);
        $this->dao->setStudent($this->student);
        $results = $this->dao->load('element', 'all');
        //$results = $this->data_access->all_element_scores($this->exam, $this->student);
        foreach ($results as $r) {
            $el_assign = \ElementAssignmentQuery::create()
                ->filterByExam($this->exam)
                ->filterByElement($r->getElement())
                ->findOne();
            $qa = \QuestionAssignerQuery::create()
                ->filterByExam($this->exam)
                ->filterByQuestion($el_assign->getQuestion())
                ->findOne();
            $ar = array(
                'elementID' => $r->getElement()->getId(),
                'questionNumber' => $qa->getQuestionnumber(),
                'elementName' => $r->getElement()->getElementname(),
                'displayText' => $r->getElement()->getDisplaytext(),
                'elementScore' => $r->getElementscore(),
                'subtask' => $el_assign->getSubtask());
            array_push($this->element_scores, $ar);
        }
    }

    public function make_array(){}

    /**
     * Retrieves scores for a single element and stores in self::element_scores
     * @param \OutputClasses\facades\IVisitor $visitor
     * @param \Element $element
     */
    public function get_particular_element_score(\OutputClasses\facades\IVisitor $visitor, \Element $element)
    {
        $this->load_objects($visitor);
        $this->dao->setExam($this->exam);
        $this->dao->setStudent($this->student);
        $this->element_scores = $this->dao->load('element', $element);
        //$this->element_scores = $this->data_access->particular_element_score($this->exam, $this->student, $element);
    }

    /**
     * Retrieves comments and stores in self::comments
     * @param \OutputClasses\facades\IVisitor $visitor
     */
    public function get_comments(\OutputClasses\facades\IVisitor $visitor)
    {
        $this->load_objects($visitor);
        $this->comments = $this->data_access->get_comments($this->exam, $this->student);
    }

    /**
     * In order to keep objects with db access off of the
     * public facing page, visitor only returns the ids for student and exam
     * This loads the student and exam objects expected by dao methods.
     *
     * Note that this isn't as wasteful as it seems: Propel's instance cache
     * should be holding them, so there won't be a hit to the db.
     *
     * @param \OutputClasses\facades\IVisitor $visitor
     */
    protected function load_objects(\OutputClasses\facades\IVisitor $visitor)
    {
        $this->exam = \ExamQuery::create()->filterById($visitor->examID())->findOne();
        $this->student = \StudentQuery::create()->filterById($visitor->studentID())->findOne();
        if(empty($this->question_assigns)){
            $this->load_question_assignments();
        }
    }

    public function json_question_scores()
    {
        $this->encoder->encode_and_send($this->question_scores);
//        return json_encode($this->question_scores);
    }

    public function json_element_scores()
    {
        $this->encoder->encode_and_send($this->element_scores);
//        return json_encode($this->element_scores);
    }

    public function json_comments()
    {
        $this->encoder->encode_and_send($this->comments);
//        return json_encode($this->comments);
    }
}
