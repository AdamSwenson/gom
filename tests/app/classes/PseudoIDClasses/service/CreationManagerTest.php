<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 12:51 PM
 */

namespace App\classes\PseudoIDClasses\service;


use Map\PseudoIDTableMap;
use Propel\Runtime\Propel;

class CreationManagerTest extends \TestCase
{

    public $pid_maker;
    public $dao;
    public $exam;
    protected $object;
    protected $student_dao;
    protected $students;

    public function setUp()
    {
        parent::setUp();
        $this->object = new CreationManager;
        $this->pid_maker = new \App\classes\PseudoIDClasses\service\PseudoIDMaker();
        $this->dao = new \App\classes\PseudoIDClasses\dao\IPseudoIDDaoMock();

        $ecaq = \ExamClassAssignmentQuery::create()->find();
        $this->exam = $ecaq[0]->getExam();

        $this->student_dao = new \App\classes\StudentClasses\dao\IStudentLoaderMock();
        $this->students = array();
        foreach([1, 2, 3, 4, 5] as $n){
            array_push($this->students, \StudentQuery::create()->filterById($n)->findOneOrCreate());
        }
        $this->student_dao->set_response($this->students);

    }

    /**
     * @covers \App\classes\PseudoIDClasses\service\CreationManager::load_dao
     */
    public function testLoad_dao()
    {
        $this->object->load_dao($this->dao);
        $this->assertAttributeInstanceOf('\App\classes\PseudoIDClasses\dao\IPseudoIDDao', 'dao', $this->object);
    }

    /**
     * @covers \App\classes\PseudoIDClasses\service\CreationManager::load_id_maker
     */
    public function testLoad_id_maker()
    {
        $this->object->load_id_maker($this->pid_maker);
        $this->assertAttributeInstanceOf('App\classes\PseudoIDClasses\service\PseudoIDMaker', 'id_maker', $this->object);
    }

    /**
     * @covers \App\classes\PseudoIDClasses\service\CreationManager::load_student_dao
     */
    public function testLoad_student_dao()
    {
        $this->object->load_student_dao($this->student_dao);
        $this->assertAttributeInstanceOf('App\classes\StudentClasses\dao\IStudentLoader', 'student_dao', $this->object);
    }

    /**
     * @covers \App\classes\PseudoIDClasses\service\CreationManager::execute
     */
    public function testExecute()
    {
        $this->object->load_dao($this->dao);
        $this->object->load_id_maker($this->pid_maker);
        $this->object->load_student_dao($this->student_dao);

        $conn = Propel::getWriteConnection(PseudoIDTableMap::DATABASE_NAME);
        $this->object->execute($conn, $this->exam);
        $conn->commit();
    }

    /**
     * @covers \App\classes\PseudoIDClasses\service\CreationManager::execute_for_student
     */
    public function testExecute_for_student()
    {
    }
}