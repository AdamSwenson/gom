<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/15
 * Time: 4:58 PM
 */

namespace App\classes\RequestHandlers\dao;

use App\classes\StudentClasses\dao\StudentDao;
use App\classes\Traits\UserTraits;

/**
 * Class StudentsForExamGenerator
 * Returns a generator for all students associated with an exam.
 *
 * Remember, because PHP is sometimes stupid and needs to remind you
 * that it is not awesome like Python, you need to do this:
 *
 * $sg = new StudentsForExamGenerator();
 * foreach($sg($exam) as $student)
 * {
        $student
 * }
 *
 * @package StudentClasses
 */
class StudentsForExamGenerator
{
    use UserTraits;

    public $exam;

    public $dao;

    /** @var \User */
    public $user;


    public function __construct()
    {
        $this->dao = new StudentDao();
        $this->user = $this->getUser();
    }

    /**
     * Returns a generator of students
     * @param \Exam $exam
     * @return \Generator
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function __invoke(\Exam $exam)
    {
        $this->dao = new StudentDao();
        $this->user = $this->getUser();
        $this->exam = $exam;
        $assigns = \ExamClassAssignmentQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($this->exam)
            ->find();
        foreach ($assigns as $kumi_assign) {
            $sca = \StudentClassAssignmentQuery::create()
                ->filterByUser($this->user)
                ->filterByKumi($kumi_assign->getKumi())
                ->find();
            foreach ($sca as $s) {
                yield $s->getStudent();
            }
        }

    }
}