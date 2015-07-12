<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace SetupPageParts;

/**
 * Makes the elements of comment pages
 *
 * @author adam
 */
class CommentMaker {

    /** @var $panel_maker \SetupPageParts\CommentSettingsPanelMaker */
    public $panel_maker;
    
    public function set_panel_maker(\SetupPageParts\CommentSettingsPanelMaker $maker)
    {
        $this->panel_maker = $maker;
    }

    /**
     * Makes an accorion for each question number
     * @param type $qnum
     */
    public function make_question_div_open($qnum, $qtitle='') {
        return <<< HTML
                <div class="accordion">
                <h3><a href ="#">Q{$qnum} {$qtitle}</a></h3>
                <div id='q{$qnum}_setup_area' class='commentSetupArea' data="{$qnum}">
HTML;
    }

    public function make_subtask_area_open($qnum, $subnum) {
        return <<< HTML
        <div id='q{$qnum}_sub{$subnum}_area' data-questionNumber='{$qnum}' data-subtask='{$subnum}' class='subtaskArea'>
        <div class='taskNum'>{$subnum} <br/>
            <div id="s{$qnum}_{$subnum}_status" class="updateStatus"></div>
        </div>
HTML;
    }

    public function make_element_info_area($qnum, $subnum) {
        return <<< HTML
            <div class='subtaskPart elementInfo'>
                <div class="elementNamesArea">
                    <div class="elementTextHolder">
                        <label for='s{$qnum}_{$subnum}_displayText'>Text to display while grading</label><br />
                        <input type="text" class="displayText" id='s{$qnum}_{$subnum}_displayText' />
                    </div>
                    <div class="elementNicknameHolder">
                        <label for='s{$qnum}_{$subnum}_element'>Task Nickname</label> <br />
                        <input type='text' id='s{$qnum}_{$subnum}_element' class="elementName" />
                        <input type='hidden' id='s{$qnum}_{$subnum}_elementID' />
                    </div>
                </div>
                <div class="elementSelectArea">
                <select class='elementSelect' id='s{$qnum}_{$subnum}_element_select' data='s{$qnum}_{$subnum}'>
                    <option>--past exam subtasks--</option>
                </select>
                </div>
            </div>
HTML;
    }


    public function make_central_comment_area($qnum, $subnum) {
        return <<< HTML
        <div class='centralComment subtaskPart' id='s{$qnum}_{$subnum}_commentArea'>
            <label for='s{$qnum}_{$subnum}_commentID'>What students needed to do</label><br/>
            <input type='hidden' id='s{$qnum}_{$subnum}_commentID' class="commentID"/>
            <textarea rows="6" cols="80" class='centralComment commentText' id='s{$qnum}_{$subnum}_comment'></textarea>
        </div>
HTML;
    }

    public function make_comment_settings_panel($qnum, $subnum) {
        $out = <<< HTML
        <div class='panelControl'>
                <input type='button' class='prettyButton panelControlButton' data='s{$qnum}_{$subnum}' value='Settings' />
        </div>
        <div class='commentConfig subtaskPart startHidden' id='s{$qnum}_{$subnum}_panel'>
HTML;
        
        $out .= $this->panel_maker->make_panel($qnum, $subnum);
        $out .= $this->close_div();
        return $out;
    }

    public function close_div() {
        return "</div>";
    }

    public function make_subtask($qnum, $subnum) {
        $out = <<< HTML
        <div id='s{$qnum}_{$subnum}' class='subtask draggable' data-elementID=''>
HTML;
        $out .= $this->make_element_info_area($qnum, $subnum);
        $out .= $this->make_central_comment_area($qnum, $subnum);
        $out .= $this->make_comment_settings_panel($qnum, $subnum);
        $out .= $this->close_div();
        return $out;
    }

    /**
     * Makes the area
     * @param int $qnum
     * @param int $num_subtasks
     * @param string $qtitle
     */
    public function make_question($qnum, $num_subtasks, $qtitle = '') {
        
        $out = $this->make_question_div_open($qnum, $qtitle);
        for ($t = 1; $t < $num_subtasks + 1; $t++) {
            $out .= $this->make_subtask_area_open($qnum, $t);
            $out .= $this->make_subtask($qnum, $t);
            //        $out .= $this->make_central_comment_area($qnum, $t);
            //       $out .= $this->make_comment_settings_panel($qnum, $t);
            $out .= $this->close_div();
        }
        $out .= $this->close_div();
        $out .= $this->close_div();
        echo $out;
    }

}
