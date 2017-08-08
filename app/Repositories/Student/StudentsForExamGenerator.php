<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/27/15
 * Time: 2:49 PM
 */

namespace App\Repositories\Student;

use App\Exam;

/**
 * Returns a generator for all students associated with an exams.
 *
 * Remember, because PHP is sometimes stupid and needs to remind you
 * that it is not awesome like Python, you need to do this:
 *
 * $sg = new StudentsForExamGenerator();
 * foreach($sg($exams) as $s){}

 */
class StudentsForExamGenerator
{
    public $students = [];

    /**
     * Returns a generator of student objects associated with the exam
     * @param Exam $exam
     * @return \Generator
     */
    public function __invoke(Exam $exam)
    {
        $classes = $exam->classes;
        foreach ($classes as $c)
        {
            foreach($c->students as $s){
                $this->students[] = $s;
            }
        }

        //Make into an collection and sort in descending order
        $this->students = collect($this->students);
        $this->students = $this->students->sortBy('last_name');

        foreach($this->students as $student)
        {
            yield $student;
        }
    }
}