<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace OutputClasses\service;

/**
 * Description of CommentPrinter
 *
 * @author adam
 */
class CommentPrinter implements ICommentPrinter
{
    public $comment = '';

    public function question_div_opening($questionNumber)
    {
        return "<div id='q{$questionNumber}'>";
    }

    public function main_heading($questionNumber, $questionTitle)
    {
        return <<<HTML
            <h1 class='mainHeading'>Q{$questionNumber}: {$questionTitle}</h1>
HTML;
    }

    public function paragraph_open()
    {
        return "<p class='stockText generalStock'>";
    }

    public function comment_body_list_open($questionNumber)
    {
        return <<<HTML
            <p class='commentList' > <ul id='q{$questionNumber}Comments'>
HTML;
    }

    public function comment_body_paragraph($elementID, $subtask, $elementScore, $content)
    {
        return <<<HTML
            <li class='subtask{$subtask} commentParagraph' id='el{$elementID}' data='{$elementScore}'>{$content}</li>
HTML;
    }

    public function list_close()
    {
        return "</ul> "
        . "</p>";
    }
    public function element_chart_div($elementID)
    {
        return <<<HTML
            <div id='el{$elementID}Chart'></div>
HTML;
    }

    public function close_div()
    {
        return "</div>";
    }

    public function reset_comment()
    {
        unset($this->comment);
        $this->comment = '';
    }

    public function make_opening($questionNumber, $questionTitle)
    {
        $this->comment = '';
        $this->comment .= $this->question_div_opening($questionNumber);
        $this->comment .= $this->main_heading($questionNumber, $questionTitle);
        $this->comment .= $this->paragraph_open();
    }

    public function make_comment_body($questionNumber, array $commentarray)
    {
        $this->comment .= $this->comment_body_list_open($questionNumber);
        foreach ($commentarray as $c) {
            $this->comment .= $this->comment_body_paragraph($c['elementID'], $c['subtask'], $c['elementScore'], $c['content']);
        }
        $this->comment .= $this->list_close();
    }

    public function make_chart_body(array $elements)
    {
        foreach ($elements as $element) {
            $this->comment .= $this->element_chart_div($element['elementID']);
        }
    }

    public function make_closing()
    {
        $this->comment .= $this->close_div();
    }

    public function print_comment()
    {
        echo $this->comment;
    }

}
