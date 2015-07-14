<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/1/15
 * Time: 10:18 AM
 */

namespace App\classes\PseudoIDClasses\dao;


use App\classes\MockParent;

class IPseudoIDDaoMock extends MockParent implements IPseudoIDDao
{

    public function record(\Exam $exam, \Student $student, $pseudoID)
    {

    }

    public function remove($pseudoID)
    {
        // TODO: Implement remove() method.
    }

    public function look_up_from_pseudoID($pseudoID)
    {
        // TODO: Implement look_up_from_pseudoID() method.
    }

    public function look_up_from_student(\Exam $exam, \Student $student)
    {
        // TODO: Implement look_up_from_student() method.
    }

    public function remove_all_for_exam(\Exam $exam)
    {
        // TODO: Implement remove_all_for_exam() method.
    }
}