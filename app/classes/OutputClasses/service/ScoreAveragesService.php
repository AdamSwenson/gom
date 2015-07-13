<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\OutputClasses\service;

/**
 * Description of ScoreAveragesService
 *
 * DO NOT USE. USE App\classes\ScoreClasses\
 * @deprecated
 *
 * @author adam
 */
class ScoreAveragesService
{
    public $outputdata;
    public $element_averages;
    public $question_averages;

    public function set_data_access(\App\classes\OutputClasses\dao\IOutputDataAccess $outputdata)
    {
        $this->outputdata = $outputdata;
    }

    public function get_element_averages(\Exam $exam)
    {
        $this->element_averages = $this->outputdata->element_averages($exam);
    }

    public function get_question_averages(\Exam $exam)
    {
        $this->question_averages = $this->outputdata->question_averages($exam);
    }

    public function json_element_averages()
    {
        return json_encode($this->element_averages);
    }

    public function json_question_averages()
    {
        return json_encode($this->question_averages);
    }

}
