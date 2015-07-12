<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/2/15
 * Time: 2:12 PM
 */

namespace TemplateClasses\input;

/**
 * Class ExamInfoArea
 * Handles making the custom exam info area
 * @package TemplateClasses\input
 */
class ExamInfoArea extends \TemplateClasses\Controller
{
    static public $baseTemplate = "input.examinfoarea.twig";

    static public function factory()
    {
        return new ExamInfoArea();
    }

    public function make($options = array())
    {
        $this->render(self::$baseTemplate);
    }


}