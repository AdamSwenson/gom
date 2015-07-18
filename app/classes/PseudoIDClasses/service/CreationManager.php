<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/31/15
 * Time: 12:26 PM
 */

namespace App\classes\PseudoIDClasses\service;


use App\classes\PseudoIDClasses\dao\IPseudoIDDao;
use App\classes\PseudoIDClasses\service\PseudoIDMaker;
use App\classes\StudentClasses\dao\IStudentDao;
use Propel\Runtime\Connection\ConnectionWrapper;

class CreationManager implements IManager
{
    /**
     * Place an upper limit on attempts if things go wrong
     */
    const MAX_ATTEMPTS = 20;

    /** @var  $dao IPseudoIDDao */
    protected $dao;

    /** @var  $id_maker \App\classes\PseudoIDClasses\service\IPseudoIDMaker */
    protected $id_maker;

    /** @var  $students \StudentQuery */
    public $students;

    protected $connection;

    /** @var  \App\classes\StudentClasses\dao\IStudentLoader */
    protected $student_dao;

    /**
     * Set the db access object
     * @param IPseudoIDDao $dao
     */
    public function load_dao(IPseudoIDDao $dao)
    {
        $this->dao = $dao;
    }

    public function load_student_dao(IStudentDao $student_loader)
    {
        $this->student_dao = $student_loader;
    }

    /**
     * Set the object responsible for generating random values
     * @param PseudoIDMaker $id_maker
     */
    public function load_id_maker(PseudoIDMaker $id_maker)
    {
        $this->id_maker = $id_maker;
    }

    public function execute(ConnectionWrapper $conn, \Exam $exam)
    {
        $this->connection = $conn;
        $this->students = $this->student_dao->load_students_by_exam($exam);
        if(count($this->students) > 0) {
            foreach ($this->students as $student) {
                $this->execute_for_student($exam, $student);
            }
        }
    }

    /**
     * Keeps attempting to generate a unique value and insert it into the database
     * until either a unique one is successfully inserted or the MAX_ATTEMPTS is
     * reached.
     * @param \Exam $exam
     * @param \Student $student
     */
    public function execute_for_student(\Exam $exam, \Student $student)
    {
        $i = 0;
        do {
            $result = $this->attempt($exam, $student);
            if ($result === true) {
                break;
            }else{
                if($i >= self::MAX_ATTEMPTS - 5){
                    //TODO error log that got too far
                }
            }
            $i++;
            } while ($i <= self::MAX_ATTEMPTS);
    }

    /**
     * @param \Exam $exam
     * @param \Student $student
     * @return bool
     */
    protected function attempt(\Exam $exam, \Student $student)
    {
        try {
            $candidate = $this->id_maker->make();
            $pid = new \PseudoID();
            $pid->setPseudoid($candidate);
            $pid->setExam($exam);
            $pid->setStudent($student);
            $pid->save($this->connection);
            return true;
//            return $this->dao->record($exam, $student, $candidate);
        } catch (\Exception $e) {
            return false;
        }
    }

//    public function load_students(\Exam $exam)
//    {
//        $this->students = \StudentQuery::create()
//            ->useStudentClassAssignmentQuery()
//                ->useKumiQuery()
//                    ->useExamClassAssignmentQuery()
//                        ->filterByExam($exam)
//                    ->endUse()
//                ->endUse()
//            ->endUse()
//            ->find();
//    }
}