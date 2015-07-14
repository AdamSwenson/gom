<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 1:53 PM
 */

namespace App\classes\QuestionClasses\service;

use App\classes\QuestionClasses\dao\IQuestionAssignmentDAOMock;
use App\classes\RequestClasses\IRequestMock;
use App\classes\SecurityClasses\cleaning\ICleanerFactoryMock;

class QuestionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public $qa_dao;
    public $request;
    public $object;
    public $cleaner;

    protected function setUp()
    {
        parent::setUp();
        $this->cleaner = new ICleanerFactoryMock();
        $this->qa_dao = new IQuestionAssignmentDAOMock();
        $this->object = new QuestionFactory();
        $this->request = new IRequestMock();
    }

    /**
     * @covers App\classes\QuestionClasses\service\QuestionFactory::set_cleaner
     */
    public function testSet_cleaner()
    {
        $this->object->set_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('App\classes\SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }

    /**
     * @covers App\classes\QuestionClasses\service\QuestionFactory::load
     */
    public function testLoad()
    {
        $this->object->set_cleaner($this->cleaner);
        $this->request->http = array('questionID' => 1);
        $result = $this->object->load($this->request);
        $this->assertInstanceOf('\Question', $result);
    }

    /**
     * @covers App\classes\QuestionClasses\service\QuestionFactory::set_question_assignment_dao
     */
    public function testSet_question_assignment_dao()
    {

    }




    public function testLoad_blind()
    {
        //exam not set
       // $this->request['http'] = array('');
//        if (!isset($this->exam)) //if exam not set can only be load by id
//        {
//            return $this->load($request);
//        } else {
//            if (isset($request->http['questionID'])) {
//                return $this->load($request);
//            } elseif ($request->http['questionNumber']) {
//                return $this->load_by_question_number($this->exam, $request);
//            }
//        }
    }


    public function testLoad_by_question_number()
    {
//        if (isset($request->http['questionNumber'])) {
//            $qnum = $this->cleaner->sanitize($request->http['questionNumber'], 'integer');
//            if ($qnum) {
//                $qa = $this->question_assigner_dao->load($exam, $qnum);
//                return $qa->getQuestion();
//            } else {
//                return FALSE;
//            }
//        }
    }


}
