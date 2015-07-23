<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\OutputClasses\service;

use App\classes\MockParent;

/**
 * Description of ICommentPrinterMock
 *
 * @author adam
 */
class ICommentPrinterMock extends MockParent implements ICommentPrinter
{
    public $chartbody;
    public $closing;
    public $commentbody;
    public $opening;
    public $questionNumber_make_comment_body;
    public $questionNumber_make_opening;
    public $questionTitle;
    public $commentTextParagraphs;
    public $elements;
    public $printcomment;
    public $reset;

    public function make_chart_body(array $elements)
    {
        $this->elements = $elements;
    }

    public function make_closing()
    {
        $this->closing = true;
    }

    public function make_comment_body($questionNumber, array $commentarray)
    {
        $this->questionNumber_make_comment_body = $questionNumber;
        $this->commentTextParagraphs = $commentarray;
    }

    public function make_opening($questionNumber, $questionTitle)
    {
        $this->questionNumber_make_opening = $questionNumber;
        $this->questionTitle = $questionTitle;
    }

    public function print_comment()
    {
        $this->printcomment = true;
    }

    public function reset_comment()
    {
        $this->reset = true;
    }

}
