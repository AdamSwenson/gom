<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/15
 * Time: 4:58 PM
 */

namespace App\classes\StudentClasses;

/**
 * Class StudentsForExamGenerator
 * Returns a generator for all students associated with an exam.
 *
 * Remember, because PHP is sometimes stupid and needs to remind you
 * that it is not awesome like Python, you need to do this:
 *
 * $sg = new StudentsForExamGenerator();
 * foreach($sg($exam) as $s){}
 *
 * @package StudentClasses
 */
class StudentsForExamGenerator
{
    public $exam;

    /**
     * Returns a generator of students
     * @param \Exam $exam
     * @return \Generator
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function __invoke(\Exam $exam)
    {
        $this->exam = $exam;
        $assigns = \ExamClassAssignmentQuery::create()->filterByExam($this->exam)->find();
        foreach ($assigns as $kumi_assign) {
            $sca = \StudentClassAssignmentQuery::create()->filterByKumi($kumi_assign->getKumi())->find();
            foreach ($sca as $s) {
                yield $s->getStudent();
            }
        }

    }
}