<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:36 PM
 */

namespace App\classes\StudentClasses\dao;


use App\classes\Traits\UserTraits;
use classes\StudentClasses\errors\StudentException;
use Map\StudentTableMap;
use Propel\Runtime\Propel;

/**
 * Class StudentDao
 * This handles all database interactions with the students table and
 * related junction tables
 * @package App\classes\StudentClasses\dao
 */
class StudentDao implements IStudentDao
{
    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }

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
     * @param \Exam $exam
     * @return mixed
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_students_by_exam(\Exam $exam)
    {
        $results = array();
        $ecaq = \ExamClassAssignmentQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($exam)
            ->find();
        foreach($ecaq as $k){
            $studentAssigns = \StudentClassAssignmentQuery::create()
                ->filterByUser($this->user)
                ->filterByKumi($k->getKumi())
                ->find();
            foreach($studentAssigns as $s)
            {
                array_push($results, $s->getStudent());
            }
        }

        return $results;

//        return \StudentQuery::create()
//            ->filterByUser($this->user)
////            ->useStudentClassAssignmentQuery()
//                ->useKumiQuery()
//                    ->useExamClassAssignmentQuery()
//                        ->filterByExam($exam)
//                    ->endUse()
//                ->endUse()
//            ->endUse()
//            ->find();
    }

    /**
     * Returns all students associated with the user
     */
    public function load_all_students()
    {
        return \StudentQuery::create()
            ->filterByUser($this->user)
            ->find();
    }

    /**
     * Loads all students associated with a given class.
     * @param \Kumi $kumi
     * @return \Propel\Runtime\Collection\ObjectCollection|\StudentClassAssignment[]
     */
    public function load_students_by_class(\Kumi $kumi)
    {
        return \StudentClassAssignmentQuery::create()
            ->filterByUser($this->user)
            ->filterByKumi($kumi)
            ->find();
    }

    /**
     * Returns a student object corresponding to the internally used id.
     * Make sure the id has been properly sanitized before passing in
     * @param $clean_id
     * @return \Student
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_student_by_id($clean_id)
    {
    return \StudentQuery::create()
        ->filterByUser($this->user)
        ->filterById($clean_id)
        ->findOneOrCreate();
    }

    /**
     * Returns a student corresponding to the user defined student id.
     * Make sure the id has been properly sanitized before passing in
     *
     * @param $clean_id
     * @return \Student
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_student_by_sid($clean_id)
    {
        return \StudentQuery::create()
            ->filterByUser($this->user)
            ->filterBySid($clean_id)
            ->findOneOrCreate();
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
        try {
            $examid = $exam->getId();
            $query = "SELECT s.studentName, s.sid
		          FROM students s
                  INNER JOIN studentsXclasses sxc ON s.id = sxc.studentID
                  INNER JOIN examsXclasses exc ON exc.classID = sxc.classID
                  WHERE examID = :examID
                  AND s.user_id = :userID
                  AND sxc.user_id = :userID
                  AND exc.user_id = :userID
                  AND sid REGEXP '^{$param}'";

            $con = Propel::getWriteConnection(StudentTableMap::DATABASE_NAME);
            $stmt = $con->prepare($query);
            $stmt->execute(array(':examID' => $examid, ':userID' => $this->user->getId()));
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $results = $stmt->fetchAll();
            return $results;
        } catch (\PDOException $e) {
            throw new StudentException(StudentException::INVALID_AUTOCOMPLETE, $e);
        }
    }

    /**
     * Alters the email associated with the student
     * @param $clean_sid
     * @param $clean_email
     * @return mixed
     */
    public function update_email($clean_sid, $clean_email)
    {
        $student = $this->load_by_sid($clean_sid);
        $student->setEmail($clean_email);
        return $student->save();
    }

    /**
     * Removes student from database (and all associated records)
     * based on the mysql record id for the student.
     * @param $id
     * @return mixed
     */
    public function delete_student_by_id($id)
    {
        // TODO: Implement delete_student_by_id() method.
    }

    /**
     * Removes the student from the database (and all associated records)
     * based on the user provided student id number
     * @param $sid
     * @return mixed
     */
    public function delete_student_by_sid($sid)
    {
        // TODO: Implement delete_student_by_sid() method.
    }
}