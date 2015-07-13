<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/3/15
 * Time: 11:00 AM
 */

namespace CommentClasses\dao;


use classes\DbTestAids;

class CommentLoaderTest extends \PHPUnit_Framework_TestCase {

    protected $object;
    protected $inserted_examids;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new CommentLoader;

//DbTestAids::populate_item_assignments();
//
//        $populator = new \Faker\ORM\Propel\Populator($faker);
//        $populator->addEntity('Exam', 100, array(
//            'CreatedAt' => null,
//            'UpdatedAt' => null
//        ));
//        $this->inserted_examids = $populator->execute();
    }

    public function testLoad_for_exam()
    {
//        $exam = \ExamQuery::create()->findById($this->inserted_examids[3]);
//        $this->assertInstanceOf('\Exam', $exam);
    }

    public function testLoad_all()
    {
        $els = $this->object->load_all();
        foreach($els as $e){
            $this->assertInstanceOf('\Element', $e);
        }
    }

}
