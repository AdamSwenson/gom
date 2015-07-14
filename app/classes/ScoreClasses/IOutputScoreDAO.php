<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 8:57 AM
 */

namespace App\classes\ScoreClasses;


interface IOutputScoreDAO 
{

    public function all_question_scores(\Exam $exam, \Student $student);

    public function particular_question_score(\Exam $exam, \Student $student, \Question $question);

    public function all_element_scores(\Exam $exam, \Student $student);


    public function particular_element_score($exam, $student, $element);


    public function get_comments(\Exam $exam, \Student $student);


}