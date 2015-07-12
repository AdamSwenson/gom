<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/9/15
 * Time: 9:53 AM
 */

namespace ExamClasses\display;

/**
 * Class PublicNameFormatter
 * Handles formatting the exam properties for output
 * @package ExamClasses\display
 */
class PublicNameFormatter
{


//    /**
//     * This displays the exam's public identification, YEAR TERM TOPIC
//     */
//    public function publicID()
//    {
//        $out = $this->year . ' ' . $this->term . ' ' . $this->examTopic;
//        echo $out;
//    }


    /**
     * This returns string of the exam's public identification, YEAR TERM TOPIC
     * @param \Exam $exam
     * @return str The exam's public identification, YEAR TERM TOPIC
     */
    public static function return_publicID(\Exam $exam)
    {
        $out = $exam->getExamyear() . ' ' . $exam->getExamterm() . ' ' . $exam->getExamtopic();
        return $out;
    }

}