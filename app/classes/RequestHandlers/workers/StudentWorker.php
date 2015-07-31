<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 6:03 PM
 */

namespace App\classes\RequestHandlers\workers;

use App\classes\RequestHandlers\dao\IStudentDao;
use App\classes\RequestHandlers\dao\StudentDao;
use Illuminate\Database\Eloquent\Collection;

class StudentWorker extends IRequestWorker
{
    /** @var  IStudentDao */
    public $dao;

    public function __construct()
    {
        $this->dao = new StudentDao();
    }

    /**
     * Returns an App\Student with the id.
     * Note that the id here is the database id.
     * @param integer $studentId
     * @return \App\Student
     */
    public function getStudent($studentId)
    {
        return $this->dao->load_student_by_id($studentId);
    }

    /**
     * This gets an App\Student based on the id which the user has associated with them.
     * @param integer $studentIdentifier
     * @return \App\Student
     */
    public function getStudentByUserSpecifiedId($studentIdentifier)
    {

    }

    /**
     * Returns all students for exam if $examId is set.
     * Otherwise returns all students belonging to the user
     * @param null|integer $examId
     * @return Collection
     */
    public function getAllStudents($examId=null)
    {
        if(!empty($examId)){}
        else{
            return $this->dao->load_all_students();
        }
    }

    /**
     * Creates a new student in the database and returns the record as an App\Student
     *
     * @param string $lastName
     * @param string $firstName
     * @param integer $studentId
     * @param integer $examId
     * @return \App\Student
     */
    public function createStudent($lastName, $firstName, $studentId, $email=null, $examId=null)
    {
        return $this->dao->create_student($lastName, $firstName, $studentId, $email);
        //TODO Assignment dao stuff

    }

    /**
     * Remove a student from the database
     * @param integer $studentId The id of the student in the database
     * @return boolean
     */
    public function deleteStudent($studentId)
    {
        return $this->dao->delete_student_by_id($studentId);
    }

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}