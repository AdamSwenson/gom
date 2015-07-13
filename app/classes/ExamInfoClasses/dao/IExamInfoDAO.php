<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 12:57 PM
 */

namespace App\classes\ExamInfoClasses\dao;


interface IExamInfoDAO
{
    /**
     * @param \Exam $exam
     * @param \Student $student
     * @param array $exam_info_array
     * @return mixed
     */
    public function update(\Exam $exam, \Student $student, array $exam_info_array);

    /**
     * @param \Exam $exam
     * @param \Student $student
     * @return mixed
     */
    public function load(\Exam $exam, \Student $student);

}