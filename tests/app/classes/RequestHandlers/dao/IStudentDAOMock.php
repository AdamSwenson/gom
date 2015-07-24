<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/23/15
 * Time: 3:27 PM
 */

namespace classes\RequestHandlers\dao;


use App\classes\MockParent;
use App\classes\RequestHandlers\dao\IStudentDao;
use App\classes\RequestHandlers\dao\Student;

class IStudentDAOMock extends MockParent implements IStudentDao
{


    public function load_students_by_exam($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));

        return $this->response;
    }


    public function load_student_by_sid($clean_id)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($clean_id));

        return $this->response;
    }


    public function update_email($clean_sid, $clean_email)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($clean_sid, $clean_email));

        return $this->response;
    }


    public function delete_student_by_id($id)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($id));

        return $this->response;
    }

    public function delete_student_by_sid($sid)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($sid));

        return $this->response;
    }

    public function lookup_autocomplete($examId, $param)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId, $param));
        return $this->response;
    }


    public function load_all_students()
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array());
        return $this->response;
    }

    public function load_students_by_class($kumiId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($kumiId));
        return $this->response;
                }


    public function create_student($lastName, $firstName, $studentId = null, $email=null)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($lastName, $firstName, $studentId, $email));
        return $this->response;
    }

    /**
     * Returns a student object corresponding to the internally used id.
     * Make sure the id has been properly sanitized before passing in
     * @param $clean_id
     * @return Student
     */
    public function load_student_by_id($clean_id)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($clean_id));
        return $this->response;
    }
}