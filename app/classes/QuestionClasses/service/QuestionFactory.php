<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 12:50 PM
 */

namespace App\classes\QuestionClasses\service;

/**
 * Class QuestionFactory
 * This processes an incoming array for questions and loads accordingly
 * @package App\classes\QuestionClasses\service
 */
class QuestionFactory
{
    /** @var  $exam \Exam */
    public $exam;

    /** @var  $cleaner \App\classes\SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    /** @var  $question_assigner_dao \App\classes\QuestionClasses\dao\IQuestionAssignmentDAO */
    public $question_assigner_dao;

    /**
     * @param \App\classes\QuestionClasses\dao\IQuestionAssignmentDAO $dao
     */
    public function set_question_assignment_dao(\App\classes\QuestionClasses\dao\IQuestionAssignmentDAO $dao)
    {
        $this->question_assigner_dao = $dao;
    }

    /**
     * @param \Exam $exam
     */
    public function set_exam(\Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * @param \App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner
     */
    public function set_cleaner(\App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    /**
     * Determines how to load the question from the request.
     * Needs exam set first
     * @param \App\classes\RequestClasses\IRequest $request
     * @return bool|\Question|\QuestionAssigner
     */
    public function load_blind(\App\classes\RequestClasses\IRequest $request)
    {
        if (!isset($this->exam)) //if exam not set can only be load by id
        {
            return $this->load($request);
        } else {
            if (isset($request->http['questionID'])) {
                return $this->load($request);
            } elseif ($request->http['questionNumber']) {
                return $this->load_by_question_number($this->exam, $request);
            }
        }
    }

    /**
     * @param \App\classes\RequestClasses\IRequest $request
     * @return bool|\Question
     */
    public function load(\App\classes\RequestClasses\IRequest $request)
    {
        if (isset($request->http['questionID'])) {
            $id = $this->cleaner->sanitize($request->http['questionID'], 'integer');
            if ($id) {
                return \QuestionQuery::create()->filterById($id)->findOne();
            }
        } else
        {
            return FALSE;
        }
    }

    /**
     * @param \Exam $exam
     * @param \App\classes\RequestClasses\IRequest $request
     * @return bool|\Question
     */
    public function load_by_question_number(\Exam $exam, \App\classes\RequestClasses\IRequest $request)
    {
        if (isset($request->http['questionNumber'])) {
            $qnum = $this->cleaner->sanitize($request->http['questionNumber'], 'integer');
            if ($qnum) {
                $qa = $this->question_assigner_dao->load($exam, $qnum);
                return $qa->getQuestion();
            } else {
                return FALSE;
            }
        }
    }

}