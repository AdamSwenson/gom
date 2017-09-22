<?php

namespace App\Http\Controllers\Item;


use App\Exam;
use App\Http\Controllers\Controller;
use App\Kumi;
use App\Repositories\Student\IStudentRepository;
use App\Student;

/**
 * Class RosterController
 * This manages the relationships between Exams, classes (kumis), and students
 * It does not alter any of the intrinsic properties of these objects.
 *
 * @package App\Http\Controllers\Item
 */
class RosterController extends Controller
{

    public $dao;

    public function __construct(
        IStudentRepository $studentDao )
    {
        $this->middleware('auth');
        $this->dao = $studentDao;
    }


    /**
     * Creates an association between an existing student and a class/ exam.
     * Does not create or alter any info about the student.
     *
     * Called on the client:
     *          associateStudent: (store, student, exam, kumi) =>{
     *
     * @param Kumi $kumi
     * @param Student $student
     * @throws \Exception
     */
    public function associateStudent( Student $student, Kumi $kumi )
    {
        try {
            $sid = $student->id;

//        $kumi->students()->attach($sid);

            $student->kumis()->attach($kumi->id); // add the student to the kumi
            $student->save();

            $this->sendAjaxSuccess();
        } catch (Exception $e) {
            $this->sendAjaxFailure();
            throw $e;
        }

        //asynchronously update the stored list of student counts etc
//        $this->dispatch(new UpdateStoredExamStats($exam));

    }

    /**
     * Remove the association between the student, class, and exam
     *
     * Does not delete the student (so would still show up if
     * queried for the student alone or all student belonging to user).
     *
     * Nor does this affect student data. So if the student were to change
     * class sections (kumi's), we would first disassociate them from the exam/kumi
     * and then associate them with the new kumi. None of their scores or other
     * data will be affected.
     *
     * Called on client:
     *      disassociateStudent: (store, student) => {},
     * @param Kumi $kumi
     * @param Student $student
     * @throws \Exception
     */
    public function disassociateStudent( Student $student, Kumi $kumi )
    {
        try {
            $student->kumis()->detach($kumi->id);

            $this->sendAjaxSuccess();

        } catch (Exception $e) {
            $this->sendAjaxFailure();
            throw $e;
        }

    }

    /**
     * Requests that identifying information about a student
     * be permanently removed.
     * Retains student score data and other optional
     * non-identifying information about the student for use in
     * statistics etc.
     *
     * Called on client:
     *          anonymizeStudents: (store, student) =>{},
     *
     * Route
     *      POST
     *      dev/students/anon/{exam}
     *
     * @param Exam $exam
     */
    public function anonymizeStudents( Exam $exam )
    {
    }

    public function getStudentsForExam( Exam $exam )
    {
        $out = [];
        $kumis = $exam->kumis()->get();
        foreach ( $kumis as $kumi ) {
            $students = $kumi->students()->get();
            foreach ( $students as $student ) {
                $s = StudentResourceController::convertOutgoing($student);
                $s['kumiId'] = $kumi->id;
                $out[] = $s;

            }

        }
        //        $students = $this->dao->load_students_by_exam($exam->id);
        return $out;
    }

}
