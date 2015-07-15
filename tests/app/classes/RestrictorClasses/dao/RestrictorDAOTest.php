<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 10:47 AM
 */

namespace App\classes\classes\App\classes\RestrictorClasses\dao;


use App\classes\RestrictorClasses\dao\RestrictorDAO;

class RestrictorDAOTest extends \TestCase
{

    public $object;
    public $cleaner;

    public function setUp()
    {
        parent::setUp();
        $this->object = new RestrictorDAO();
        $this->cleaner = new \App\classes\SecurityClasses\cleaning\ICleanerFactoryMock();
    }


    public function testSet_cleaner()
    {
        $this->object->set_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('\App\classes\SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }

    public function testLoad_year()
    {
        $year = '2035';
        $this->cleaner->set_response(2035);
        $this->object->set_cleaner($this->cleaner);
        $result = $this->object->load_year($year);
        $this->assertInstanceOf('\Year', $result);
        $this->assertEquals('sanitize', $this->cleaner->called);
    }

    /**
     * @expectedException \Exception
     */
    public function testLoad_year_throws_on_bad_input()
    {
        $year = '2035cat';
        $this->cleaner->set_response(FALSE);
        $this->object->set_cleaner($this->cleaner);
        $this->object->load_year($year);
    }


    public function testLoad_term()
    {
        $test = 'testTerm3';
        $this->cleaner->set_response($test);
        $this->object->set_cleaner($this->cleaner);
        $result = $this->object->load_term($test);
        $this->assertInstanceOf('\Term', $result);
    }

    /**
     * @expectedException \Exception
     */
    public function testLoad_term_throws_on_bad_input()
    {
        $test = 'testTerm3';
        $this->cleaner->set_response(FALSE);
        $this->object->set_cleaner($this->cleaner);
        $this->object->load_term($test);
    }

    public function testLoad_topic()
    {
        $test = 'testTopic3';
        $this->cleaner->set_response($test);
        $this->object->set_cleaner($this->cleaner);
        $result = $this->object->load_topic($test);
        $this->assertInstanceOf('\Topic', $result);
    }

    /**
     * @expectedException \Exception
     */
    public function testLoad_topic_throws_on_bad_input()
    {
        $test = 'testTopic3';
        $this->cleaner->set_response(FALSE);
        $this->object->set_cleaner($this->cleaner);
        $this->object->load_topic($test);
    }
}
