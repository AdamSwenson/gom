<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 8:32 AM
 */

namespace App\classes\ExamClasses\display;


class ExamOptionMakerTest extends \PHPUnit_Framework_TestCase {
    public $object;

    public static $id = 34;
    public static $year = 2015;
    public static $term = 'fall';
    public static $topic = 'testTopic';
    public $topic_obj;
    public $term_obj;
    public $year_obj;
    public $exam;
    public $expected;


    protected function setUp()
    {
        parent::setUp();
        $this->object = new ExamOptionMaker();
        $this->exam = new \Exam();
        $this->year_obj = new \Year();
        $this->term_obj = new \Term();
        $this->topic_obj = new \Topic();
        $this->exam->setId(self::$id);
        $this->exam->setYear($this->year_obj->setContent(self::$year));
        $this->exam->setTerm($this->term_obj->setContent(self::$term));
        $this->exam->setTopic($this->topic_obj->setContent(self::$topic));
        $this->expected = "<option value='" . self::$id . "' data='" . self::$id . "'>" . self::$year ." " . self::$term . " " . self::$topic . "</option>";
    }

    public function testMake_option()
    {
        $this->assertEquals($this->expected, $this->object->make_option($this->exam));
    }


    public function testMake_options_from_array_of_exams()
    {
        $test = array($this->exam, $this->exam, $this->exam);
        $expect = '';
        $expect .= $this->expected;
        $expect .= $this->expected;
        $expect .= $this->expected;
        $this->assertEquals($expect, $this->object->make_options_from_array_of_exams($test));
    }


}
