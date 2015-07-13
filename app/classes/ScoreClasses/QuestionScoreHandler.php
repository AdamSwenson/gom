<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 4:06 PM
 */

namespace ScoreClasses;


class QuestionScoreHandler implements IQuestionScoreHandler
{
    /** @var  $response_handler \App\classes\JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    /** @var  $question_score_obj \QuestionScore */
    public $question_score_obj;

    /**
     * @param \App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler
     */
    public function set_response_handler(\App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }


    /**
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return mixed|\QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, \Question $question, \Student $student)
    {
        $this->question_score_obj = \QuestionScoreQuery::create()
            ->filterByExam($exam)
            ->filterByQuestion($question)
            ->filterByStudent($student)
//            ->where('studentID = ?', $student->getId())
            ->findOneOrCreate();
        return $this->question_score_obj;
    }

    /**
     * Saves the question score
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @param $score
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, \Question $question, \Student $student, $score)
    {
        $this->load($exam, $question, $student);
        $this->question_score_obj->setQuestionscore($score);
        $result = $this->question_score_obj->save();
        if($result)
        {
            $this->response_handler->handle_row_count(1);
        }
        else
        {
            $this->response_handler->handle_row_count(0);
        }
    }
}