<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 1:35 PM
 */

namespace App\classes\CommentClasses\service;


class AssignmentProcessor
{

    public $factory;

    /** @var  $cleaner \App\classes\SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    /** @var  $response_handler \App\classes\JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    /**
     * @param \App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner
     */
    public function load_cleaner(\App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner)
    {
        $this->cleaner = $cleaner;
    }


    public function set_response_handler(\App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }


    public function load_factory($factory)
    {
        $this->factory = $factory;
    }

    public function process_stock_text($incoming)
    {
    }
//
//    public function process_element_assignment($incoming)
//    {}

    /**
     * There are two incoming cases depending on whether the element and comment are new
     * (1) The ordering or content of existing items has changed
     * (2) The content of the items is brand new
     * This returns true in case 1 and false in case 2
     * @param $incoming
     */
    public function check_preexisting($incoming)
    {

    }

    /**
     * Loads a question from id
     * TODO Should be refactored out and handled by a question class
     * @param $incoming
     * @return \Propel\Runtime\Collection\ObjectCollection|\Question|\Question[]
     */
    public function process_question(array $incoming)
    {
        if (isset($incoming['questionID']) && !empty($incoming['questionID'])) {
            $question = \QuestionQuery::create()->findById($incoming['questionID']);
        } else {
            $question = new \Question();
        }
        //the following should not be used in the present context. may be used once refactored out
        if (isset($incoming['questionText']) && !empty($incoming['questionText'])) {
            $question->setQuestiontext($incoming['questionText']);
        }

        return $question;
    }

    /**
     * Loads element from id
     * TODO Should be refactored and handled by a class for this
     * @param $incoming
     * @return \Element
     */
    public function process_element(array $incoming)
    {
        if (isset($incoming['elementID']) && !empty($incoming['elementID'])) {
            $element = \ElementQuery::create()
                ->filterById($incoming['elementID'])
                ->findOne();
        } else {
            $element = new \Element();
        }
        if (isset($incoming['elementName']) && !empty($incoming['elementName'])) {
            $element->setElementname($incoming['elementName']);
            $element->save();
        }
        if (isset($incoming['displayText']) && !empty($incoming['displayText'])) {
            $element->setDisplaytext($incoming['displayText']);
            $element->save();
        }
        if (isset($incoming['commentText']) && !empty($incoming['commentText'])) {
            $element->setCommenttext($incoming['commentText']);
            $element->save();
        }
        return $element;
    }

//    /**
//     * Loads comment from id
//     * TODO Should be refactored out
//     * @param $incoming
//     * @return \Comment|\Comment[]|\Propel\Runtime\Collection\ObjectCollection
//     */
//    public function process_comment(array $incoming)
//    {
//        if (isset($incoming['commentID']) && !empty($incoming['commentID'])) {
//            $comment = \CommentQuery::create()->findById($incoming['commentID']);
//        } else {
//            $comment = new \Comment();
//        }
//        if (isset($incoming['commentText']) && !empty($incoming['commentText'])) {
//            $comment->setCommenttext($incoming['commentText']);
//            $comment->save();
//        }
//        return $comment;
//    }

    public function process($incoming, \Exam $exam)
    {
//        if (!empty($incoming['elementText']) && !empty($incoming['commentText']))
//        {
            if (isset($incoming['subtask']) && isset($incoming['questionNumber']))
            {
                $questionNumber = $incoming['questionNumber'];
                $subtask = $incoming['subtask'];
                $qa = \QuestionAssignerQuery::create()->filterByExam($exam)->filterByQuestionnumber($questionNumber)->findOne();
                $question = $qa->getQuestion();

//            $question = $this->process_question($incoming);
                $element = $this->process_element($incoming);
           //     $comment = $this->process_comment($incoming);

                $eq = \ElementAssignmentQuery::create()->filterByExam($exam)
                    ->filterByQuestion($question)
                    ->filterBySubtask($subtask)
                    ->findOneOrCreate();
                $eq->setElement($element);
                $eq->save();
                $this->response_handler->handle_row_count(1);
            }
            else
            {
                $this->response_handler->handle_row_count(0);
            }
//        }
//        else
//        {
//            $this->response_handler->handle_row_count(0);
//        }
    }


public function process_score_assignment($incoming, \Exam $exam)
{
    //This handles score assignment
    $this->factory->set_exam($exam);
    $element = \ElementQuery::create()->filterById()->findOneOrCreate();
    $this->factory->set_element($element);
    $this->process_missing($incoming);
    $this->process_poor($incoming);
    $this->process_competent($incoming);
    $this->process_excellent($incoming);

//        $properties = ['questionNumber',
//        'subtask',
//        'missing_min' => array('type' => 'missing'),
//        'missing_max',
//        'poor_min',
//        'poor_max',
//        'competent_min',
//        'competent_max',
//        'excellent_min',
//        'excellent_max'];
}


public
function process_missing($incoming)
{
    if (isset($incoming['missing_min']) && isset($incoming['missing_max'])) {
        $object = $this->factory->load('missing');
        $object->setMinscore($this->cleaner->sanitize($incoming['missing_min'], 'float'));
        $object->setMaxscore($this->cleaner->sanitize($incoming['missing_max'], 'float'));
        $object->save();
        return $object;
    }
}

public function process_poor($incoming)
{
    if (isset($incoming['poor_min']) && isset($incoming['poor_max'])) {
        $object = $this->factory->load('poor');
        $object->setMinscore($this->cleaner->sanitize($incoming['poor_min'], 'float'));
        $object->setMaxscore($this->cleaner->sanitize($incoming['poor_max'], 'float'));
        $object->save();
    }
}

public function process_competent($incoming)
{
    if (isset($incoming['competent_min']) && isset($incoming['competent_max'])) {
        $object = $this->factory->load('competent');
        $object->setMinscore($this->cleaner->sanitize($incoming['competent_min'], 'float'));
        $object->setMaxscore($this->cleaner->sanitize($incoming['competent_max'], 'float'));
        $object->save();
    }
}

public function process_excellent($incoming)
{
    if (isset($incoming['excellent_min']) && isset($incoming['excellent_max'])) {
        $object = $this->factory->load('excellent');
        $object->setMinscore($this->cleaner->sanitize($incoming['excellent_min'], 'float'));
        $object->setMaxscore($this->cleaner->sanitize($incoming['excellent_max'], 'float'));
        $object->save();
    }

}
}