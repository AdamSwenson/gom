<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:52 PM
 */
namespace App\Repositories\Student;

use App\Student;

interface IStudentRepository
{
    /**
     * Add a new student to the database
     *
     * Todo: Add sanitization
     *
     * @param $lastName
     * @param $firstName
     * @param null $studentId
     * @return Student
     */
    public function create_student($lastName, $firstName, $studentId = null, $email = null);

    /**
     * Returns all students associated with an exam
     *
     * this is essentially doing something like:
     * SELECT sxc.sid FROM studentsXclasses sxc
     * INNER JOIN classesXexams c ON sxc.classID = c.classID
     * WHERE c.examID = :examID"
     *
     * TODO: Fix schema so that this again works programmatically with propel
     *
     * @param $examId
     * @return mixed
     */
    public function load_students_by_exam($examId);

    /**
     * Returns all students associated with the user
     * @return Collection
     */
    public function load_all_students();

    /**
     * Loads all students associated with a given class.
     * @param $kumiId
     */
    public function load_students_by_class($kumiId);

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
     */
    public function load_student_by_sid($clean_id);

    /**
     * Handles the database queries for the autocomplete function
     * on the main grading page
     * @param \Exam $exam
     * @param $param
     * @return mixed
     * @throws \Exception
     */
    public function lookup_autocomplete($examId, $param);

    /**
     * Alters the email associated with the student
     * @param integer $clean_sid
     * @param string $clean_email
     * @return Student
     */
    public function update_email($clean_sid, $clean_email);

    /**
     * Removes student from database (and all associated records)
     * based on the mysql record id for the student.
     * @param $id
     * @return boolean
     */
    public function delete_student_by_id($id);

    /**
     * Removes the student from the database (and all associated records)
     * based on the user provided student id number
     * @param integer $sid
     * @return boolean
     */
    public function delete_student_by_sid($sid);
}