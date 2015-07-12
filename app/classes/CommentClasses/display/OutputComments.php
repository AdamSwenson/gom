<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/11/15
 * Time: 1:10 PM
 */

namespace CommentClasses\display;

/**
 * Class OutputComments
 * Used to output a json object for use by javascript when page first loads
 *
 * @package CommentClasses\display
 */
class OutputComments
{

    /** @var  \JsonOutputClasses\encoders\IJsonOutput */
    public $encoder;

    /** @var  \ElementClasses\dao\ElementAssignmentDAO  */
    public $loader;

    /** @var  \Exam */
    public $exam;

    /** @var array Stores the student records while they are being prepared */
    public $students = array();

    /**
     * Loads the class which handles outputting as json
     * @param \JsonOutputClasses\encoders\IJsonOutput $encoder
     */
    public function set_encoder(\JsonOutputClasses\encoders\IJsonOutput $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Loads class which handles db queries
     * @param \ElementClasses\dao\ElementAssignmentDAO $loader
     */
    public function set_loader(\ElementClasses\dao\ElementAssignmentDAO $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Outputs a json object of all current questions or an empty json
     */
    public function display_all()
    {
        $output = array();
        $eq = \ElementQuery::create()->find();
        foreach ($eq as $element) {
                $f = array(
                    'elementID' => $element->getId(),
                    'elementName' => $element->getElementname(),
                    'displayText' => $element->getDisplaytext(),
                    'commentID' => $element->getId(),
                    'commentText' => $element->getCommenttext()
                );
                array_push($output, $f);
            }
        $this->encoder->encode_and_send($output);
    }

    public function display_for_exam(\Exam $exam)
    {
//        $element_assign = $this->loader->load_by_exam($exam);
//        var_dump($element_assign);
//        if(count($element_assign) > 0) {
//            foreach ($element_assign as $ea) {
//                $f = array(
//
//                    'subtask' => $ea->getQuestionassigner()->getSubtask(),
//                    'questionNumber' => $ea->getQuestionassigner()->getQuestionnumber(),
//                    'elementID' => $ea->getElement()->getId(),
//                    'questionID' => $ea->getQuestion()->getId(),
//                    'elementName' => $ea->getElement()->getElementname(),
//                    'elementText' => $ea->getElement()->getDisplaytext(),
//                    'commentID' => $ea->getElement()->getId(),
//                    'commentText' => $ea->getElement()->getCommenttext()
//                );
//                array_push($output, $f);
//            }
//            $this->encoder->encode_and_send($output);
//
//        }
        $output = array();
        $element_assign = \ElementAssignmentQuery::create()
            ->filterByExam($exam)
            ->find();
        if($element_assign) {
            foreach ($element_assign as $ea) {
                $element = $ea->getElement();
                $question = $ea->getQuestion();
                $qa = \QuestionAssignerQuery::create()
                    ->filterByExam($exam)
                    ->filterByQuestion($question)
                    ->findOne();
                if ($qa) {
                    $questionNumber = $qa->getQuestionnumber();
                    $subtask = $ea->getSubtask();
                    $f = array(
                        'subtask' => $subtask,
                        'questionNumber' => $questionNumber,
                        'elementID' => $element->getId(),
                        'questionID' => $question->getId(),
                        'elementName' => $element->getElementname(),
                        'elementText' => $element->getDisplaytext(),
                        'commentID' => $element->getId(),
                        'commentText' => $element->getCommenttext()
                    );
                    array_push($output, $f);
                }
            }
        }
        $this->encoder->encode_and_send($output);
    }
}