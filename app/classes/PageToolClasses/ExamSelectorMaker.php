<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace PageToolClasses;

/**
 * This creates the div for exam selector block in setup pages.
 * Replaces include('pagecomponents/examselector')
 * 
 * Should include examchoicebutton.js and examselectorStyles.css
 * @author adam
 */
class ExamSelectorMaker
{

    /** @var $current_exam_html String to display as the identifier of the currently set exam */
    public $current_exam_html = '';

    /** @var $exam_status_html String to use for exam status */
    public $exam_status_html = '';

    /** @var $options_html HTML string of all the options to put inside the selector */
    public $options_html = '';

    public $examID = '';
    /**
     * Set the html string of all the options to add to the selector
     * @param string $options_html
     */
    public function set_options($options_html) {
        $this->options_html = $options_html;
    }

    /**
     * Set the string to display identifying the current exam
     * @param string $current_exam_html
     */
    public function set_current_exam($current_exam_html) {
        $this->current_exam_html = $current_exam_html;
    }

    /**
     * Set the string to go into the hidden 'examStatus' field
     * @param type $exam_status_html
     */
    public function set_exam_status($exam_status_html) {
        $this->exam_status_html = $exam_status_html;
    }
    
    public function set_exam_id($examid){
        $this->examID = $examid;
    }

    /**
     * @return str Returns string representing div class examselector    
     */
    public function make() {
        return <<<OUT
            <div class="examselector">
                <p>Current Exam: <br/>
                    <span class="currentExamString">{$this->current_exam_html}</span>
                        <input type="hidden" name="examID" id="currentExamID" value="{$this->examID}" readonly="readonly" /> <br />
                    <select id="examTarget" class="examSelect">
                        <option> Change exam </option>
                        {$this->options_html}
                    </select>
                    <input type="hidden" id="examStatus" value="{$this->exam_status_html}" />
                </p>
            </div>
OUT;
    }

}
