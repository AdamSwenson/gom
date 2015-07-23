<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\OutputClasses\display;

/**
 * Description of FeedbackController
 *
 * @author adam
 */
class FeedbackController
{
    public $question;
    public $elements = array();
    public $comments = array();

    /**
     *
     * @param type  $question
     * @param array $element_array Array of elements objects
     * @param array $comment_array Array of comments objects
     */
    public function load($question, $element_array, $comment_array)
    {
        $this->question = $question;
        $this->elements = $element_array;
        $this->comments = $comment_array;

    }

    public function makeForQuestion(\OutputClasses\display\QuestionDivMaker $question_div_maker, \OutputClasses\display\CommentsMaker $comments_maker)
    {
        $question_div_maker->makeOpeningDivTag($this->question);
        $question_div_maker->makeHeading($this->question);
        foreach ($this->elements as $element) {
            $comments_maker->makeCommentsListOpening($this->question);
            foreach ($this->comments as $comment) {
                $comments_maker->addComment($comment, $element);
            }
            $question_div_maker->makeElementChartDiv($element);

        }
    }

}
