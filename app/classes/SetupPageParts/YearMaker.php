<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/1/15
 * Time: 4:51 PM
 */

namespace SetupPageParts;


class YearMaker extends ExamSetupMaker
{
    public static $years = array(2014, 2015, 2016, 2017, 2018, 2019, 2020);

    public function make_selector()
    {
        $out = "<select id='yearSelector' class='yearSelect newExamPart'>";
        foreach(self::$years as $year){
            $out .= "<option value='$year' data='$year'>$year</option>";
        }
        $out .= "</select>";
        echo $out;
    }
}