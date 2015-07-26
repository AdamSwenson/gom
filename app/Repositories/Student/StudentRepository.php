<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:50 PM
 */

namespace App\Repositories\Student;


use App\Student;

class StudentRepository implements IStudentRepository
{

    /** @var  $cleaner ICleanerFactory */
    public $cleaner;

    /**
     * Loads the class which handles cleaning before query
     * @param ICleanerFactory $cleanerFactory
     */
    public function set_cleaner(ICleanerFactory $cleanerFactory)
    {
        $this->cleaner = $cleanerFactory;
    }

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
    public function create_student($lastName, $firstName, $studentId=null, $email=null)
    {
        $cleanLastName = $lastName;
        $cleanFirstName = $firstName;
        $cleanStudentId = $studentId;
        if(!empty($email))
        {
            $cleanEmail = $email;
        }

        $student = new Student();
        $student->last_name = $cleanLastName;
        $student->first_name = $cleanFirstName;
        $student->student_identifier = $cleanStudentId;
        if($cleanEmail)
        {
            $student->email = $cleanEmail;
        }
        $student->save();

//        $student = Student::firstOrCreate(
//            [
//                'last_name' => $cleanLastName,
//                'first_name' => $cleanFirstName,
//                'student_identifier' => $cleanStudentId
//            ]
//        );
//        $student->save();
        return $student;
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
     * @param $examId
     * @return mixed
     */
    public function load_students_by_exam($examId)
    {
        $exam = Exam::findOrFail($examId);
        $classes = $exam->classes()->get();
        if(count($classes) > 0)
        {
            return $classes->students()->get();
        }
    }

    /**
     * Returns all students associated with the user
     * @return Collection
     */
    public function load_all_students()
    {
        return Student::all();
    }

    /**
     * Loads all students associated with a given class.
     * @param $kumiId
     */
    public function load_students_by_class($kumiId)
    {
    }

    /**
     * Returns a student object corresponding to the internally used id.
     * Make sure the id has been properly sanitized before passing in
     * @param $clean_id
     * @return Student
     */
    public function load_student_by_id($clean_id)
    {
        return Student::findOrFail($clean_id);
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
        return Student::where('student_identifier', $clean_id)->first();
    }


    /**
     * Handles the database queries for the autocomplete function
     * on the main grading page
     * @param \Exam $exam
     * @param $param
     * @return mixed
     * @throws \Exception
     */
    public function lookup_autocomplete($examId, $param)
    {
//        try {
//            $examid = $exam->getId();
//            $query = "SELECT s.studentName, s.sid
//		          FROM students s
//                  INNER JOIN studentsXclasses sxc ON s.id = sxc.studentID
//                  INNER JOIN examsXclasses exc ON exc.classID = sxc.classID
//                  WHERE examID = :examID
//                  AND s.user_id = :userID
//                  AND sxc.user_id = :userID
//                  AND exc.user_id = :userID
//                  AND sid REGEXP '^{$param}'";
//
//            $con = Propel::getWriteConnection(StudentTableMap::DATABASE_NAME);
//            $stmt = $con->prepare($query);
//            $stmt->execute(array(':examID' => $examid, ':userID' => $this->user->getId()));
//            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
//            $results = $stmt->fetchAll();
//            return $results;
//        } catch (\PDOException $e) {
//            throw new StudentException(StudentException::INVALID_AUTOCOMPLETE, $e);
//        }
    }

    /**
     * Alters the email associated with the student
     * @param integer $clean_sid
     * @param string $clean_email
     * @return Student
     */
    public function update_email($clean_sid, $clean_email)
    {
        $student = $this->load_student_by_id($clean_sid);
        $student->setEmail($clean_email);
        $student->update();
        return $student;
    }

    /**
     * Removes student from database (and all associated records)
     * based on the mysql record id for the student.
     * @param $id
     * @return boolean
     */
    public function delete_student_by_id($id)
    {
        return Student::destroy($id);
    }

    /**
     * Removes the student from the database (and all associated records)
     * based on the user provided student id number
     * @param integer $sid
     * @return boolean
     */
    public function delete_student_by_sid($sid)
    {
        $student = $this->load_student_by_sid($sid);
        return $student->delete();
    }
}