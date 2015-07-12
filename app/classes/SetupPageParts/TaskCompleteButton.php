<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace SetupPageParts;

/**
 * This makes the div and button for marking the task on the page complete
 *
 * @author adam
 */
class TaskCompleteButton
{
    /**
     * Makes the button inside a div class 'taskcompleteButton'
     * @param string $buttonid   The id of the button
     * @param string $taskstring String to follow the word 'Done ' in the value of the button
     */
    public static function make($buttonid, $taskstring)
    {
        echo "<div class='taskcompleteButton'>
            <label for='$buttonid'>Done $taskstring</label>
            <input type='checkbox' id='$buttonid' class='taskComplete' value='Done $taskstring' />
            </div>";
    }
    
    /**
     * Makes the button inside a div class 'taskcompleteButton'
     * @param string $buttonid   The id of the button
     * @param string $taskstring String to follow the word 'Done ' in the value of the button
     * @return string Returns the html string of the button div
     */
    public static function return_button($buttonid, $taskstring)
    {
        $out = "<div class='taskcompleteButton'>
            <label for='$buttonid'>Done $taskstring</label>
            <input type='checkbox' id='$buttonid' class='taskComplete' value='Done $taskstring' />
            </div>";
        return $out;
    }
}
