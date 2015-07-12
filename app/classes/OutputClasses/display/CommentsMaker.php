<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace OutputClasses\display;

/**
 * Description of CommentsMaker
 *
 * @author adam
 */
class CommentsMaker
{
    public function makeCommentsListOpening($question_number)
    {
        return "<ul id='q{$question_number}Comments'>";
    }

    public function makeCommentsListClosing()
    {
        return "</ul>";
    }

    public function addComment($elementID, $comment_text)
    {
        return "<li class='subtask commentParagraph' id='el{$elementID}'>{$comment_text}</li>";
    }

}
