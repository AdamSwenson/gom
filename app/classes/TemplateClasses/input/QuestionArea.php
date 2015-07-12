<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/2/15
 * Time: 2:06 PM
 */

namespace TemplateClasses\input;

/**
 * Class QuestionArea
 * Handles building question selector and question divs
 * @package TemplateClasses\input
 */
class QuestionArea extends \TemplateClasses\Controller
{
    static public $baseTemplate = 'input.body.twig';

    static public function factory()
    {
        return new QuestionArea();
    }

    public function makeQuestionArea($numberOfQuestions)
    {
        $questionNumbers = range(1, $numberOfQuestions);

        $this->add_variables(array('questionNumbers' => $questionNumbers));
        $this->render(self::$baseTemplate);
    }


}