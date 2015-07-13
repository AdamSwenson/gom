<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:36 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\GradeClasses\service\GradeMaker;

class GradeWorker extends  IRequestWorker
{

    # Grade assigner
    public function assignCalcGrade()
    {
        $displayNumeric = '';
        $displayText = '';
        $args = array();
        $grade_obj = GradeMaker::factory(GradeMaker::CALCULATED,
            $displayText, $displayNumeric, $args);
    }

    public function assignDirectGrade()
    {
        $displayNumeric = '';
        $displayText = '';
        $args = array();
        $grade_obj = GradeMaker::factory(GradeMaker::DIRECT,
            $displayText, $displayNumeric);
    }

    public function getGradeAssignments()
    {
    }

    public function handle($request)
    {
        $this->loadHelpers();

        switch($request->task())
        {
            case 'assignCalcGrade':
                $this->assignCalcGrade($request);
                break;
            case 'assignDirectGrade':
                $this->assignDirectGrade($request);
                break;
        }

    }
}