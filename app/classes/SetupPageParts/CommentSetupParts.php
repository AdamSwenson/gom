<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace SetupPageParts;

class CommentSetupParts
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function editor()
    {
        echo "<div id='commentEdit'>
		<p>
                    <label for='commentSelector'>Select existing comment to edit</label> <br />
                    <select id='commentSelector'>
                        <option>Select comment</option>";
                        $getComments = array('printSelector' => true, 'send' => false);
                        $c = new \App\classes\CommentClassesGetAllComments($this->user, $getComments);
        echo "</select>
            </p>
            <label for='commentID'>Comment ID: </label><input type='text' id='commentID' readonly='readonly' value='new' class='comment emptyMe'/><br/>
            <label for='commentSummary'>Comment summary: </label><input type='text' id='commentSummary' class='comment emptyMe'/><br />
            <textarea id='content' rows='6' cols='50' class='comment emptyMe'></textarea>
            <p>
                <input type='button' id='recordCommentEdit' class='prettyButton' value='Record Comment Changes' />
                <input type='button' id='resetCommentEdit' class='resetButton prettyButton' data='editCommentFields' value='Clear Comment Fields' />
            </p>
	</div>";
    }

    public function assigner()
    {
        echo "<div id='commentAssociation'>
            <p>
            <select id='examSel' class='examSelector'>
                <option> --select exam-- </option>";
        $ex = new \ExaminationClasses\service\GetAllExams($this->user, 'unlocked', 'all');
        $ex->print_selector();
        echo "</select>
            </p>
            <p>
                <label for='questionNumber'>Question:</label> <select id='questionNumber' class='questionSelect'><option>Select question</option></select><br />
                <label for='elementID'>Element:</label> <select id='elementID' class='elementSelect'><option>Select element</option></select>
            </p>
            <input type='button' id='commentsDone' class='prettyButton' value='Done assigning comments'/>
	</div>
        <div id='rangeAssignment'>
		<p>Assign minimum and maximum scores for the comment (optional)</p>
		<label for='minRangeBox'>Minimum score </label><input type='text' id='minRangeBox' class='comment emptyMe'/> <br />
		<label for='maxRangeBox'>Maximum score </label><input type='text' id='maxRangeBox' class='comment emptyMe'/> <br />
		<div id='commentRange' class='rangeSlider'></div>
	</div><!--rangeassignment-->

	<div id='existingAssoc'></div>
	<input type='button' id='assignComment' value='Record comment assignment' class='prettyButton'/>";
    }

    public function instructions()
    {
        echo "<p class='instructions'>I strongly recommend writing all the comments in a document and then pasting them here.
                 * That way you won't lose anything if there's a problem. Keep in mind that pasting from Word often leads to a nasty surprise when the content you paste is filled with all sorts of formatting. To avoid this, follow the instructions here [link]</p>
         ";
    }

}
