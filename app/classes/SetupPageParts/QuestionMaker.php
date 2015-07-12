<?php

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/3/15
 * Time: 8:28 AM
 */

namespace SetupPageParts;

/**
 * Class QuestionMaker
 * Makes the boxes for the questionsetup page
 * @package SetupPageParts
 */
class QuestionMaker {

    public function make_title_box() {
        
    }

    /**
     * Displays the question number
     * @param $qnum Integer
     * @param $qnum_class String The class to be used in the display of the question number
     * @return string
     */
    public function make_question_number($qnum, $qnum_class = 'qnumDisplay') {
        return "<div class='$qnum_class questionSetupPart'>Q{$qnum}</div>";
    }

    public function make_question_title_box($qnum) {
        return <<< HTML
        <div class='questionTitle questionSetupPart'>
            <label for='q{$qnum}_name' class='questionNameLabel'>Question Nickname</label> <br />
            <input type='text' id='q{$qnum}_name' class='questionName' />
            <input type="hidden" id='q{$qnum}_questionID' data='{$qnum}' value=''/> <br />
            <select id='q{$qnum}_select' class='questionSelect' data='{$qnum}'>
                <option>---questions used on past exams---</option>
            </select>
        </div>
HTML;
    }

    public function make_question_text_box($qnum) {
        return <<< HTML
        <div class="questionText questionSetupPart">
        <label for="q{$qnum}_text" class="questionTextLabel">Question text</label><br/>
        <textarea cols=50 rows=5 id="q{$qnum}_text" class="questionTextArea"></textarea>
        </div>
HTML;
    }

    /**
     * Creates and displays the question div
     * @param Integer $qnum
     */
    public function make_question($qnum) {
        $out = "<div id='q{$qnum}_area' class='questionArea'>";
        $out .= $this->make_question_number($qnum);
        $out .= $this->make_question_text_box($qnum);
        $out .= $this->make_question_title_box($qnum);

        $out .= "</div>";
        echo $out;
    }

}
