<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/13/15
 * Time: 10:22 AM
 */

namespace App\Http\Controllers\helpers;


use App\classes\ExamClasses\service\CurrentExamManager;

class ExamSelectorHelper
{
    public $exam;


    public function __construct()
    {
        $current_exam_manager = new CurrentExamManager();
        $this->exam = $current_exam_manager->get_current_exam();
    }

    /**
     * Takes the array that's about to go to the view and
     * adds the bits for the exam selector
     * @param array $outArray
     * @return array
     */
    public function makeExamSelectorComponent(array $outArray)
    {
        if ($this->exam)
        {
            $outArray['currentExamId'] = $this->exam->getId();
            $outArray['currentExamString'] = $this->makeExamDisplayText($this->exam);
        } else
        {
            $outArray['currentExamId'] = '';
            $outArray['currentExamString'] = '';
        }
        $outArray['examOptions'] = $this->makeExamArray();

        return $outArray;
    }

    protected function makeExamDisplayText($exam)
    {
        $text = $exam->getExamyear() . ' ' . $exam->getExamterm() . '  ' . $exam->getExamtopic();
        return $text;
    }

    protected function makeExamArray()
    {
        $exams = \ExamQuery::create()->find();
        $examList = array();
        if (count($exams) > 0)
        {
            foreach ($exams as $e)
            {
                array_push($examList, [
                    'optionId' => $e->getId(),
                    'optionValue' => $e->getId(),
                    'optionText' => $this->makeExamDisplayText($e)
                ]);
            }
        }
        return $examList;
    }


}