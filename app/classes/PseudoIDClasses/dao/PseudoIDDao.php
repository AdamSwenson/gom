<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/31/15
 * Time: 1:12 PM
 */

namespace App\classes\PseudoIDClasses\dao;


class PseudoIDDao implements IPseudoIDDao
{

    public function record(\Exam $exam, \Student $student, $pseudoID)
    {
        $pid = new \PseudoID();
        $pid->setPseudoid($pseudoID);
        $pid->setExam($exam);
        $pid->setStudent($student);
        return $pid->save();
    }

    /**
     * Removes the specified pseudoID
     * @param $pseudoID
     * @return int
     */
    public function remove($pseudoID)
    {
        return \PseudoIDQuery::create()->filterByPseudoid($pseudoID)->delete();
    }

    public function remove_all_for_exam(\Exam $exam)
    {
        return \PseudoIDQuery::create()->filterByExam($exam)->delete();
    }

    /**
     * Looks up a student by their temporary identifier
     * @param  $pseudoID Int
     * @return \Student
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function look_up_from_pseudoID($pseudoID)
    {
        return \StudentQuery::create()->filterByPseudoID($pseudoID)->findOne();
//      $pid = \PseudoIDQuery::create()->filterByExam($exam)->filterByPseudoid($pseudoID)->findOne();
    }

    /**
     * @param \Exam $exam
     * @param \Student $student
     * @return \PseudoID
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function look_up_from_student(\Exam $exam, \Student $student)
    {
        return \PseudoIDQuery::create()->filterByExam($exam)->filterByStudent($student)->findOne();
    }


}