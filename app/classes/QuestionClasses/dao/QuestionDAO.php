<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 12:43 PM
 */

namespace App\classes\QuestionClasses\dao;


use App\classes\Traits\UserTraits;

class QuestionDAO implements IQuestionDAO
{

    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }
    /**
     * Loads a question object from an array
     * @param array $incoming
     * @return \Question
     */
    public function get_question_from_array(array $incoming)
    {
        if (isset($incoming['questionID']) && ($incoming['questionID'] > 0)) {
            $question = $this->get_question($incoming['questionID']);
        } else {
            $question = new \Question();
        }
        return $this->load_question_content($question, $incoming);
    }

    /**
     * Handles getting a new question object to deal with the various legal
     * incoming arrays.
     * @param int $questionID
     * @return Question
     */
    public function get_question($questionID)
    {
        $question = \QuestionQuery::create()
            ->filterByUser($this->user)
            ->filterById($questionID)
            ->findOneOrCreate();
//        if($question->isNew()){
//            $question->save();
//        }
        return $question;
    }

    /**
     * Fills a question with content from incoming
     * @param \Question $question
     * @param array $incoming
     * @return \Question
     */
    public function load_question_content(\Question $question, array $incoming)
    {
        if (isset($incoming['questionText'])) {
            $question->setQuestiontext($incoming['questionText']);
            if (isset($incoming['questionName'])) {
                $question->setQuestionname($incoming['questionName']);
            }//not an error if questionName isn't set
        } else {
            //error: question text is required
        }
        return $question;
    }


}