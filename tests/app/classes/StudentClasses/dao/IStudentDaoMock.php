<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:49 PM
 */

namespace App\classes\StudentClasses\dao;


use App\classes\MockParent;

class IStudentDaoMock extends MockParent implements IStudentDao
{

    public function load_students_by_exam(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
        return $this->response;
    }

    /**
     * Returns a student corresponding to the user defined student id.
     * Make sure the id has been properly sanitized before passing in
     *
     * @param $clean_id
     * @return \Student
     * @throws \Propel\Runtime\Exception\PropelException
     * @internal param $sid
     */
    public function load_student_by_sid($clean_id)
    {
        $this->record_call(__FUNCTION__, array($clean_id));
        return $this->response;
    }

    /**
     * Alters the email associated with the student
     * @param $clean_sid
     * @param $clean_email
     * @return mixed
     */
    public function update_email($clean_sid, $clean_email)
    {
        $this->record_call(__FUNCTION__, array($clean_sid, $clean_email));
        return $this->response;
    }

    /**
     * Removes student from database (and all associated records)
     * based on the mysql record id for the student.
     * @param $id
     * @return mixed
     */
    public function delete_student_by_id($id)
    {
        $this->record_call(__FUNCTION__, array($id));
        return $this->response;
    }

    /**
     * Removes the student from the database (and all associated records)
     * based on the user provided student id number
     * @param $sid
     * @return mixed
     */
    public function delete_student_by_sid($sid)
    {
        $this->record_call(__FUNCTION__, array($sid));
        return $this->response;
    }

    /**
     * Handles the database queries for the autocomplete function
     * on the main grading page
     * @param \Exam $exam
     * @param $param
     * @return mixed
     * @throws \Exception
     */
    public function lookup_autocomplete(\Exam $exam, $param)
    {
        $this->record_call(__FUNCTION__, array($exam, $param));
        return $this->response;
    }

    /**
     * Returns all students associated with the user
     */
    public function load_all_students()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    /**
     * Loads all students associated with a given class.
     * @param \Kumi $kumi
     */
    public function load_students_by_class(\Kumi $kumi)
    {
        $this->record_call(__FUNCTION__, array($kumi));
        return $this->response;
    }
}