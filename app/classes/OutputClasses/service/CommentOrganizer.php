<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\OutputClasses\service;

/**
 * Puts comments in correct order then hands to printer
 *
 * @author adam
 */
class CommentOrganizer
{
    /** @var $printer \App\classes\OutputClasses\service\ICommentPrinter */
    public $printer;
    public $comments;
    public $questionNumbers = array();
    //public $questionTitles = array();
    /** @var $sorted_comments array Holds the comments once they have been sorted */
    public $sorted_comments = array();

    public function set_printer(\App\classes\OutputClasses\service\ICommentPrinter $printer)
    {
        $this->printer = $printer;
    }

    public function load_comment_array(array $comments)
    {
        $this->comments = $comments;
    }

    public function set_question_numbers(array $comments)
    {
        foreach ($comments as $comment) {
            if (!in_array($comment['questionNumber'], $this->questionNumbers)) {
                array_push($this->questionNumbers, $comment['questionNumber']);
                //$this->questionTitles[$comment['questionNumber']] = $comment['questionTitle'];
                $this->sorted_comments[$comment['questionNumber']] = array();
            }
            array_push($this->sorted_comments[$comment['questionNumber']], $comment);
        }
        sort($this->questionNumbers);
    }

    /**
     * Sort the comments for each question in sorted_comments by subtask
     */
    public function sort_comments()
    {
        foreach ($this->questionNumbers as $q) {
            uasort($this->sorted_comments[$q], function ($a, $b) {
                return $a['subtask'] - $b['subtask'];
            });
        }
    }

    /**
     * When a question number and questiontitle get passed in, bundle the comment text and element data in arrays ready for the make function
     * @param int    $questionNumber
     * @param string $questionTitle
     */
    public function run($questionNumber, $questionTitle)
    {
        if (count($this->sorted_comments) > 0) {
            $comments = $this->sorted_comments[$questionNumber];
            $elements = array();
            if (count($comments) > 0) {
                foreach ($comments as $c) {
                    array_push($elements, array('elementID' => $c['elementID'], 'elementScore' => $c['elementScore'], 'subtask' => $c['subtask']));
                }
                $this->make($questionNumber, $questionTitle, $comments, $elements);
            }
        }
    }

    public function make($questionNumber, $questionTitle, array $comments, array $elements)
    {
        $this->printer->reset_comment();
        // $this->printer->make_opening($questionNumber, $questionTitle);
        $this->printer->make_comment_body($questionNumber, $comments);
        $this->printer->make_chart_body($elements);
        //$this->printer->make_closing();
        $this->printer->print_comment();
    }

}
