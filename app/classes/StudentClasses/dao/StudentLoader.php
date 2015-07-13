<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:36 PM
 */

namespace App\classes\StudentClasses\dao;


class StudentLoader implements IStudentLoader
{
    public $students;

    public function load_students_by_exam(\Exam $exam)
    {
        $this->students = \StudentQuery::create()
            ->useStudentClassAssignmentQuery()
                ->useKumiQuery()
                    ->useExamClassAssignmentQuery()
                        ->filterByExam($exam)
                    ->endUse()
                ->endUse()
            ->endUse()
            ->find();
        return $this->students;
    }
}