<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/31/15
 * Time: 1:14 PM
 */

namespace App\classes\PseudoIDClasses\dao;


interface IPseudoIDDao
{

    public function record(\Exam $exam, \Student $student, $pseudoID);

    public function remove($pseudoID);

    public function remove_all_for_exam(\Exam $exam);

    public function look_up_from_pseudoID($pseudoID);

    public function look_up_from_student(\Exam $exam, \Student $student);
}