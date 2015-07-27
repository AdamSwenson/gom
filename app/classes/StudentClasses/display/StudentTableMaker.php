<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/3/15
 * Time: 7:34 AM
 */

namespace App\classes\StudentClasses\display;

/**
 * Class StudentTableMaker
 * Outputs students for table
 * @package App\classes\StudentClasses\display
 */
class StudentTableMaker
{
    /** @var  \App\classes\JsonOutputClasses\encoders\DirectJsonOutput */
    public $encoder;

    /** @var  \App\classes\StudentClasses\dao\IStudentLoader */
    public $loader;

    /** @var  \Exam */
    public $exam;

    /** @var array Stores the student records while they are being prepared */
    public $students = array();

    /**
     * Loads the class which handles outputting as json
     * @param \App\classes\JsonOutputClasses\encoders\DirectJsonOutput $encoder
     */
    public function set_encoder(\App\classes\JsonOutputClasses\encoders\DirectJsonOutput $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Loads class which handles db queries for students
     * @param \App\classes\StudentClasses\dao\IStudentLoader $loader
     */
    public function set_student_loader(\App\classes\StudentClasses\dao\IStudentLoader $loader)
    {
        $this->loader = $loader;
    }

    public function display_for_exam(\Exam $exam)
    {
        try {
            $records = $this->loader->load_students_by_exam($exam);
            if (count($records) < 1) {
                throw new \Exception();
            }
            foreach ($records as $student) {
                $this->build_row($student);
            }
            if (count($this->students) < 1) {
                throw new \Exception();
            }
            $this->encoder->encode_and_send($this->students);
        } catch (\Exception $e) {
            $this->output_empty();
        }
    }

    public function build_row(\Student $student)
    {
        $sca = $student->getStudentClassAssignments();
        $class_name = $sca[0]->getKumi()->getNickname();
        $out = array(
            'class_nickname' => $class_name,
            'student_id' => $student->getSid(),
            'student_name' => $student->getStudentname(),
            'emails' => $student->getEmail()
        );
        array_push($this->students, $out);
    }

    /**
     * If there are no student records, this does the expected output.
     */
    public function output_empty()
    {
        echo "''";
    }
}