<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace OutputClasses\service;

/**
 *
 * @author adam
 */
interface ICommentPrinter
{
    public function make_opening($questionNumber, $questionTitle);

    public function make_comment_body($questionNumber, array $commentarray);

    public function make_chart_body(array $elements);

    public function make_closing();

    public function print_comment();

    public function reset_comment();
}
