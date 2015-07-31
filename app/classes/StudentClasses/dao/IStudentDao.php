<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:40 PM
 */

namespace App\classes\StudentClasses\dao;

/**
 * Interface IStudentDao
 * This handles all database interactions with the students table and
 * related junction tables
 * @package App\classes\StudentClasses\dao
 */
interface IStudentDao
{

    /**
     * Returns all students associated with an exam
     * @param \Exam $exam
     * @return mixed
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_students_by_exam(\Exam $exam);

    /**
     * Returns a student corresponding to the user defined student id.
     * Make sure the id has been properly sanitized before passing in
     *
     * @param $clean_id
     * @return \Student
     * @throws \Propel\Runtime\Exception\PropelException
     * @internal param $sid
     */
    public function load_student_by_sid($clean_id);

    /**
     * Alters the email associated with the student
     * @param $clean_sid
     * @param $clean_email
     * @return mixed
     */
    public function update_email($clean_sid, $clean_email);

    /**
     * Removes student from database (and all associated records)
     * based on the mysql record id for the student.
     * @param $id
     * @return mixed
     */
    public function delete_student_by_id($id);


    /**
     * Removes the student from the database (and all associated records)
     * based on the user provided student id number
     * @param $sid
     * @return mixed
     */
    public function delete_student_by_sid($sid);

    /**
     * Handles the database queries for the autocomplete function
     * on the main grading page
     * @param \Exam $exam
     * @param $param
     * @return mixed
     * @throws \Exception
     */
    public function lookup_autocomplete(\Exam $exam, $param);

    /**
     * Returns all students associated with the user
     */
    public function load_all_students();

    /**
     * Loads all students associated with a given class.
     * @param \Kumi $kumi
     */
    public function load_students_by_class(\Kumi $kumi);

}