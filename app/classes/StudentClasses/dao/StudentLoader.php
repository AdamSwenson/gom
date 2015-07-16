<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:36 PM
 */

namespace App\classes\StudentClasses\dao;


use App\classes\Traits\UserTraits;

class StudentLoader implements IStudentLoader
{
    public $students;


    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }

    /**
     * Returns all students associated with an exam
     * @param \Exam $exam
     * @return mixed
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_students_by_exam(\Exam $exam)
    {
        $this->students = \StudentQuery::create()
            ->filterByUser($this->user)
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

    /**
     * Returns a student object corresponding to the internally used id
     * @param $clean_id
     * @return \Student
     * @throws \Propel\Runtime\Exception\PropelException
     * @internal param $id
     */
    public function load_student_by_id($clean_id)
    {
    return \StudentQuery::create()
        ->filterByUser($this->user)
        ->filterById($clean_id)
        ->findOneOrCreate();
    }

    /**
     * Returns a student corresponding to the user defined student id
     * @param $clean_id
     * @return \Student
     * @throws \Propel\Runtime\Exception\PropelException
     * @internal param $sid
     */
    public function load_student_by_sid($clean_id)
    {
        return \StudentQuery::create()->filterByUser($this->user)
            ->filterBySid($clean_id)
            ->findOneOrCreate();
    }

    public function update_email($sid, $email)
    {}

    public function delete_student($sid)
    {
    }
}