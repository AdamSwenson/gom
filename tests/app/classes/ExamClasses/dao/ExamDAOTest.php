<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 9:52 PM
 */
namespace App\classes\ExamClasses\dao;

class ExamDAOTest extends \TestCase
//\Propel\Tests\TestCase
//\Propel\Tests\TestCaseFixtures
    //\Propel\Tests\TestCaseFixturesDatabase
//PHPUnit_Framework_TestCase
{
    public $term;
    public $year;
    public $topic;
    public $object;
    public $user;


    public function setUp()
    {
        parent::setUp();
        $this->object = new ExamDAO();
        $this->user = \UserQuery::create()->filterById(self::$userid)->findOneOrCreate();
        $this->year = \YearQuery::create()->filterByUser($this->user)->filterByContent(2015)->findOneOrCreate();
        $this->term = \TermQuery::create()->filterByUser($this->user)->filterByContent('testTerm')->findOneOrCreate();
        $this->topic = \TopicQuery::create()->filterByUser($this->user)->filterByContent('testTopic')->findOneOrCreate();
    }

    public function makeexam($term, $year, $topic, $locked=0)
    {

        $yr = \YearQuery::create()->filterByUser($this->user)->filterByContent($year)->findOneOrCreate();
        $tm = \TermQuery::create()->filterByUser($this->user)->filterByContent($term)->findOneOrCreate();
        $tc = \TopicQuery::create()->filterByUser($this->user)->filterByContent($topic)->findOneOrCreate();
        $ex = new \Exam();
        $ex->setUser($this->user);
        $ex->setTopic($tc);
        $ex->setTerm($tm);
        $ex->setYear($yr);
        $ex->save();
    }

    public function testSave_new_exam()
    {
        $result = $this->object->save_new_exam($this->year, $this->term, $this->topic);
        $this->assertInstanceOf('\Exam', $result);
        $this->assertEquals($this->year->getContent(), $result->getYear()->getContent());
        $this->assertEquals($this->term->getContent(), $result->getTerm()->getContent());
        $this->assertEquals($this->topic->getContent(), $result->getTopic()->getContent());
    }

    public function testLoad_all_exams()
    {
        $result = $this->object->load_all_exams();
        $this->assertTrue(count($result) >= 1);
    }

    public function testLoad_unlocked_exams()
    {
    }


    public function testLock_exam()
    {
    }


    public function testUnlock_exam()
    {
      }

    public function testMark_exam_released()
    {

    }


    public function testUnmark_exam_released()
    {
    }



}