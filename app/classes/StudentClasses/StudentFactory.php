<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 3:34 PM
 */

namespace StudentClasses;


class StudentFactory
{
    /** var $student \Student*/
    public $student;

    /** @var  $cleaner \SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    public function set_cleaner(\SecurityClasses\cleaning\ICleanerFactory $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    public function load_from_request(\RequestClasses\IRequest $request)
    {
        if (isset($request->http['student_id'])) {
            return $this->load_by_id($request->http['student_id']);
        } elseif (isset($request->http['sid'])) {
            return $this->load_by_sid($request->http['sid']);
        }
    }


    /**
     * Adds a new student to the db
     * @param $sid User given student id
     * @param $studentName
     * @param string $email
     * @return mixed
     */
    public function add_student($sid, $studentName, $email = '')
    {
        $this->load_by_sid($sid);
        $this->student->setStudentname($studentName);
        if ($email !== '') {
            $this->student->setEmail($email);
        }
        $this->student->save();
        return $this->student;
    }

    /**
     * Loads a student object by the gom id of the student
     * @param $id
     * @return \Student
     */
    public
    function load_by_id($id)
    {
        $clean_id = $this->cleaner->sanitize($id, 'integer');
        $this->student = \StudentQuery::create()->filterById($clean_id)->findOneOrCreate();
        return $this->student;
    }

    /**
     * Loads a student object by the user given id for the student
     * @param $sid
     * @return \Student
     */
    public
    function load_by_sid($sid)
    {
        $clean_id = $this->cleaner->sanitize($sid, 'integer');
        $this->student = \StudentQuery::create()->filterBySid($clean_id)->findOneOrCreate();
        return $this->student;
    }

    public
    function update_email($sid, $email)
    {
        if ((!isset($this->student)) || ($this->student->getId() !== $sid)) {
            $this->load_by_sid($sid);
            $this->student->setEmail($email);
        }
    }

    public
    function delete_student($sid)
    {
    }
}