<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 4:06 PM
 */

namespace App\classes\ScoreClasses;


use App\classes\JsonOutputClasses\controllers\IResponseChooser;
use App\classes\Traits\UserTraits;

class ElementScoreHandler implements IElementScoreHandler
{

    /** @var  $response_handler IResponseChooser */
    public $response_handler;

    /** @var  $score_obj \ElementScore */
    public $score_obj;

    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }
    /**
     * @param IResponseChooser $response_handler
     */
    public function set_response_handler(IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }


    /**
     * @param \Exam $exam
     * @param \Element $element
     * @param \Student $student
     * @return mixed|\QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, \Element $element, \Student $student)
    {
        $this->score_obj = \ElementScoreQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($exam)
            ->filterByElement($element)
            ->filterByStudent($student)
//            ->where('studentID = ?', $student->getId())
            ->findOneOrCreate();
        return $this->score_obj;
    }

    /**
     * Saves the question score
     * @param \Exam $exam
     * @param \Element $element
     * @param \Student $student
     * @param $score
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, \Element $element, \Student $student, $score)
    {
        $this->load($exam, $element, $student);
        $this->score_obj->setElementscore($score);
        $result = $this->score_obj->save();
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