<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 8:25 AM
 */

namespace App\classes\ExamClasses\display;

/**
 * DEPRECATED
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * Class ExamOptionMaker
 * @deprecated
 * @package App\classes\ExamClasses\display
 */
class ExamOptionMaker
{
    public function all_exams($unlocked_only=false)
    {
        if($unlocked_only){
            $exams = \ExamQuery::create()->filterByLocked(0)->find();
        }else{
            $exams = \ExamQuery::create()->find();
        }
        echo $this->make_options_from_array_of_exams($exams);
    }

    public function make_options_from_array_of_exams($exams)
    {
        $out = '';
        foreach($exams as $exam){
            $out .= $this->make_option($exam);
        }
        return $out;
    }

    /**
     * This is used to print options inside a selector which display the exams associated with a user on forms like questionmanager
     * @param \Exam $exam
     * @return string
     */
    public function make_option(\Exam $exam)
    {
        return "<option value='{$exam->getId()}' data='{$exam->getId()}'>{$exam->getYear()->getContent()} {$exam->getTerm()->getContent()} {$exam->getTopic()->getContent()}</option>";
    }
}