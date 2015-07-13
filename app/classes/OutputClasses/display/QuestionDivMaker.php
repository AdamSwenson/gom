<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\OutputClasses\display;

use QuestionAssigner;

/**
 * This makes an entire output div for a question, including heading, comments, and place for chart
 *
 * @author adam
 */
class QuestionDivMaker
{
    const QUESTION_CHART_HEIGHT = '400px';
    const QUESTION_CHART_WIDTH = '800px';

    /**
     * @param QuestionAssigner $question
     * @return string
     */
    public function makeOpeningDivTag(\QuestionAssigner $question)
    {
        return <<<HTML
<div id='q{$question->getQuestionnumber()}'>
HTML;
    }

    public function makeClosingDivTag()
    {
        return "</div>";
    }

    /**
     * @param QuestionAssigner $question
     * @return string
     */
    public function makeHeading(\QuestionAssigner $question)
    {
        return <<<HTML
<h1 class='mainHeading'>Q{$question->getQuestionnumber()}: {$question->getQuestion()->getQuestionname()}</h1>
<p class='stockText generalStock'></p>
HTML;
    }

    /**
     * @param \Element $element
     * @return string
     */
    public function makeElementChartDiv(\Element $element)
    {
        return <<<HTML
<div id='el{$element->getId()}Chart'></div>
HTML;
    }

    /**
     * @param QuestionAssigner $question
     * @return string
     */
    public function makeCommentsArea(\QuestionAssigner $question)
    {
        return <<<HTML
<ul id='q{$question->getQuestionnumber()}Comments'></ul>
HTML;
    }

    /**
     * @param QuestionAssigner $question
     * @return string
     */
    public function makeQuestionChartDiv(\QuestionAssigner $question)
    {
        $h = self::QUESTION_CHART_HEIGHT;
        $w =self::QUESTION_CHART_WIDTH;
        return <<<HTML
<div id='Q{$question->getQuestionNumber()}Chart' class='elementChartDiv' style='height:{$h}; width:{$w}' > </div>
HTML;
    }
}