<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:50 PM
 */

namespace App\Repositories\Student;


use App\Exam;
use App\Http\Requests\StudentRequest;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StudentRepository implements IStudentRepository
{

    /** @var  $cleaner ICleanerFactory */
    public $cleaner;

    /** @var  Exam The exam passed in the request */
    public $exam;

    /** @var \App\Http\Controllers\helpers\validation\IStudentRecordValidator */
    public $studentValidator;

    /** @var \App\Repositories\Student\IKumiRepository */
    public $kumiRepository;

    /** @var array Holds the ids of students that are present in the current request */
    protected $idsOnRosterIncludingInvalid = [];

    protected $currentStudents = []; //keeping for now, probably won't be used

    /** @var  array Holds all students associated with the exam */
    protected $allStudents;

    public function __construct()
    {
        $this->studentValidator = app()->make('App\Http\Controllers\helpers\validation\IStudentRecordValidator');
        $this->kumiRepository = app()->make('App\Repositories\Student\IKumiRepository');
        //   $this->cleaner = app()->make('App\HTTP\Controllers\helpers\cleaning\CleanerFactory');
    }


    /**
     * Add or update student records.
     * This is the main method called by the roster editor
     *
     * @param Exam $exam
     * @param Request $request
     * @return array Student objects from the db for this exam
     */
    public function update_all(Exam $exam, Request $request)
    {
        $this->exam = $exam;

        /*
         * Figure out which records are valid, pushing their row numbers into $this->studentValidator->validRecords
         * and $this->studentValidator->invalidRecords respectively
         */
        $this->studentValidator->validateStudents($request);

        /* Load or retrieve Kumi for the exam */
        $kumi = $this->kumiRepository->loadOrCreateKumiForExam($this->exam);

        /* Update the database */
        $this->updateStudentsInDatabase($request, $kumi);

        /* Now, we're going to delete previously associated students whom the user deleted in this request */
        $this->deleteStudentsNotOnRoster($request);

        /* Finally, we're going to need to do some work to return the expected list
         * First, we load all students who are now in the db
         */
        $this->allStudents = $this->load_students_by_exam($this->exam->getId());

        /*
         * The user is going to be pissed if they have to retype the invalid
         * records. Not to mention the difficulty of figuring out what the problem was
         * if they can't see the original.
         * So, we'll return back the invalid records but add a class so that the
         * client can add styling to make it easier for the user to identify them.
        */
        if (!empty($this->studentValidator->invalidRecords))
        {
            foreach ($this->studentValidator->invalidRecords as $i)
            {
                //We need to decide whether it was a preexisting record or a new
                //record which was invalid lest we push two records back
                if ($request->input('id' . $i) != 0)
                {
                    //existing record
                    foreach ($this->allStudents as $row)
                    {
                        if ($row['id'] == $request->input('id' . $i))
                        {
                            //Add a failed key which the browser will use to attach a failure class
                            $row['failed'] = 'invalidRecord';
                            break;
                        }
                    }
                } else
                {
                    $this->allStudents[] = [
                        'failed' => 'invalidRecord',
                        'last_name' => $request->input('lastName' . $i),
                        'first_name' => $request->input('firstName' . $i),
                        'email' => $request->input('email' . $i),
                        'student_identifier' => $request->input('studentIdentifier' . $i),
                        'id' => $request->input('id' . $i)
                    ];
                }
            }
        }

        return $this->allStudents;
    }

    /**
     * This handles all the database operations for updating students.
     * It creates or updates all valid records from $request (the validator needs to have
     * been called previously) and deletes records from the database that were not
     * in the incoming request (which includes both valid and invalid records).
     *
     * This will write the data for all students with every pass, modifying the time updated field,
     * regardless of whether the data has changed.
     *
     * It also updates the $this->currentStudents array in preparation for deleting
     *
     * @param $request
     * @param $kumi
     */
    public function updateStudentsInDatabase(Request $request, $kumi)
    {
        //Write valid student records to the database and store them in $this->currentStudents
        foreach ($this->studentValidator->validRecords as $rowNumber)
        {
            $lName = $request->input('lastName' . $rowNumber);
            $fName = $request->input('firstName' . $rowNumber);
            $email = $request->input('email' . $rowNumber);
            $identifier = $request->input('studentIdentifier' . $rowNumber);
            $id = $request->input('id' . $rowNumber);
            $student = null;

            if ($id == 0) //new students have id==0
            {
                // create new student
                $student = $this->create_student($lName, $fName, $identifier, $email);
                $id = $student->getId();
                $student->kumis()->attach($kumi); // add the student to the kumi
            } else
            {
                //otherwise update an existing record
                $student = $this->load_student_by_id($id);
                $student->setStudentFName($fName);
                $student->setStudentLName($lName);
                $student->setStudentId($identifier);
                $student->setEmail($email);
                $student->save();
            }

            //Add to list of students on the current exam
            $this->idsOnRosterIncludingInvalid[] = $student->getId();
            $this->currentStudents[$id] = $student;
        }
    }


    /**
     * Because we don't want to destroy preexisting records if they were made invalid
     * in the request, we add them to $this->idsOnRosterIncludingInvalid
     * @param $request
     */
    public function addInvalidIdsToList(Request $request)
    {
        if (!empty($this->studentValidator->invalidRecords))
        {

            foreach ($this->studentValidator->invalidRecords as $rowId)
            {
                $recordId = $request->input('id' . $rowId);
                if ($recordId !== 0) //Incoming records with id == 0 are new
                {
                    $this->idsOnRosterIncludingInvalid[] = $recordId;
                }
            }
        }
    }

    /**
     * This will load any previously existing student who ended up in invalid
     * records into $this->currentStudents and then delete any students in $this->allStudents
     * who is not in $this->currentStudents
     *
     * It's broader purpose is to handle deleting the students who were not on the roster that was submitted.
     * That is, we need to delete any students from the database whom the user
     * deleted.
     *
     * But we need to be careful. If there were invalid records in the request,
     * the user might not have intended to delete the student. For example, they
     * may have gone back to add an email address after grading a student's exam
     * and mistyped the email address. If we we're just to delete everything not in
     * the validStudents array, all the work of grading the student would be lost.
     *
     *
     * @param Request $request
     */
    public function deleteStudentsNotOnRoster(Request $request)
    {
        /*
         * First, we will try loading students with invalid records. Note that we don't
         * care if the id can't be found in the db. Nor do we care if they were a new record
         * (since they wouldn't be in the db and the row will be passed back to the user later).
         */
        $this->addInvalidIdsToList($request);

        /* Now we can go through and delete any previously associated students
         * who are not on the roster
         */
        $studentsInDb = $this->load_students_by_exam($this->exam->getId());
        if (count($studentsInDb) > 0 && count($this->idsOnRosterIncludingInvalid) > 0)
        {
            foreach ($studentsInDb as $student)
            {
                if (!in_array($student->getId(), $this->idsOnRosterIncludingInvalid))
                {
                    $student->delete();
                }
            }
        }
    }


    /**
     * Since several functions can be passed either an exam object or
     * the id of an exam, this determines which has been passed in and returns
     * the appropriate exam object.
     *
     * @param $exam_or_examId
     * @return Exam
     * @throws \Exception
     */
    protected function determineType($exam_or_examId)
    {
        if ($exam_or_examId instanceof Exam)
        {
            return $exam_or_examId;
        } else
        {
            $examId = (int)$exam_or_examId;
            if (is_integer($examId))
            {
                return Exam::findOrFail($examId);
            } else
            {
                throw new \Exception('invalid type passed in');
            }
        }
    }

    /**
     * Updates an existing record
     * @param Student $preExisting
     * @param $lastName
     * @param $firstName
     * @param $email
     * @return Student
     */
    protected function update(Student $preExisting, $lastName, $firstName, $email)
    {
        $cleanLastName = $lastName;
        $cleanFirstName = $firstName;
        $cleanEmail = $email;
        if (!empty($email))
        {
            $cleanEmail = $email;
        }

        $preExisting->setStudentLName($cleanLastName);
        $preExisting->setStudentFName($cleanFirstName);
        if ($cleanEmail)
        {
            $preExisting->setEmail($cleanEmail);
        }
        $preExisting->update();

        return $preExisting;
    }


    /**
     * Add a new student to the database
     *
     *
     * @param $lastName
     * @param $firstName
     * @param null $studentId
     * @param null $email
     * @return Student
     */
    public function create_student($lastName, $firstName, $studentId = null, $email = null)
    {
        $cleanLastName = $lastName;
        $cleanFirstName = $firstName;
        $cleanStudentId = $studentId;

        $cleanEmail = !empty($email) ? $email : "";

        $preExisting = $this->load_student_by_sid($cleanStudentId);
        if (!empty($preExisting))
        {
            $student = $this->update($preExisting, $cleanLastName, $cleanFirstName, $cleanEmail = null);
        } else
        {
            $student = new Student();
            $student->setStudentId($cleanStudentId);//needs to be used so id will be encrypted
            $student->setStudentLName($cleanLastName);
            $student->setStudentFName($cleanFirstName);
            if ($cleanEmail)
            {
                $student->setEmail($cleanEmail); //needs to be used so email will be encrypted
            }
            $student->save();
        }

        return $student;
    }

    /**
     * Returns all students associated with an exam sorted in
     * descending order by last name
     *
     * this is essentially doing something like:
     * SELECT sxc.sid FROM studentsXclasses sxc
     * INNER JOIN classesXexams c ON sxc.classID = c.classID
     * WHERE c.examID = :examID"
     *
     *
     * @param Exam|int $exam_or_examId
     * @return Collection Ordered by last name
     */
    public function load_students_by_exam($exam_or_examId)
    {
        $students = [];

        $exam = $this->determineType($exam_or_examId);
        if ($exam)
        {
            $classes = $exam->classes;
            foreach ($classes as $c)
            {
                foreach ($c->students as $s)
                {
                    //array_push($students, $s);
                    $students[$s->getId()] = $s;
                }
            }
        }
        //Make into an array and sort in descending order
        $students = collect($students);
        $students = $students->sortBy('last_name');

        return $students;
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
     */
    public function load_student_by_sid($clean_id)
    {
        return Student::where('student_identifier', $clean_id)->first();
    }


//    /**
//     * Handles the database queries for the autocomplete function
//     * on the main grading page
//     * @param \Exam $exam
//     * @param $param
//     * @return mixed
//     * @throws \Exception
//     */
//    public function lookup_autocomplete($examId, $param)
//    {
////        try {
////            $examid = $exam->getId();
////            $query = "SELECT s.studentName, s.sid
////		          FROM students s
////                  INNER JOIN studentsXclasses sxc ON s.id = sxc.studentID
////                  INNER JOIN examsXclasses exc ON exc.classID = sxc.classID
////                  WHERE examID = :examID
////                  AND s.user_id = :userID
////                  AND sxc.user_id = :userID
////                  AND exc.user_id = :userID
////                  AND sid REGEXP '^{$param}'";
////
////            $con = Propel::getWriteConnection(StudentTableMap::DATABASE_NAME);
////            $stmt = $con->prepare($query);
////            $stmt->execute(array(':examID' => $examid, ':userID' => $this->user->getId()));
////            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
////            $results = $stmt->fetchAll();
////            return $results;
////        } catch (\PDOException $e) {
////            throw new StudentException(StudentException::INVALID_AUTOCOMPLETE, $e);
////        }
//    }

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

    public function delete_student_by_object(Student $student)
    {
        return $student->delete();
    }
}