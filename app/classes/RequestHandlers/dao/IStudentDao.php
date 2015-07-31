<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:40 PM
 */

namespace App\classes\RequestHandlers\dao;

use App\Student;

/**
 * Interface IStudentDao
 * This handles all database interactions with the students table and
 * related junction tables
 * @package App\classes\StudentClasses\dao
 */
interface IStudentDao
{
    /**
     * Create a new student
     * @param $lastName
     * @param $firstName
     * @param null $studentId
     * @param null $email
     * @return Student
     */
    public function create_student($lastName, $firstName, $studentId=null, $email=null);

    /**
     * Returns all students associated with an exam
     * @param $examId
     * @return mixed
     */
    public function load_students_by_exam($examId);

    /**
     * Returns a student object corresponding to the internally used id.
     * Make sure the id has been properly sanitized before passing in
     * @param $clean_id
     * @return Student
     */
    public function load_student_by_id($clean_id);

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
     * @param $examId
     * @param $param
     */
    public function lookup_autocomplete($examId, $param);

    /**
     * Returns all students associated with the user
     */
    public function load_all_students();

    /**
     * Loads all students associated with a given class.
     * @param $kumiId
     * @return
     */
    public function load_students_by_class($kumiId);

}