<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 12:17 PM
 */

namespace App\classes\CommentClasses\service;


use App\classes\CommentClasses\dao\IStockTextDaoMock;
use App\classes\JsonOutputClasses\controllers\IResponseChooserMock;
use App\classes\SecurityClasses\cleaning\ICleanerFactoryMock;

class StockTextProcessorTest extends \PHPUnit_Framework_TestCase {

    public $object;
    public $cleaner;
    public $handler;


    protected function setUp()
    {
        parent::setUp();
        $this->object = new StockTextProcessor();
        $this->cleaner = new ICleanerFactoryMock();
        $this->handler = new IResponseChooserMock();
        $this->dao = new IStockTextDaoMock();
    }

    public function testLoad_cleaner()
    {
        $this->object->load_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('\App\classes\SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }


    public function testSet_response_handler()
    {
        $this->object->set_response_handler($this->handler);
        $this->assertAttributeInstanceOf('\App\classes\JsonOutputClasses\controllers\IResponseChooser', 'response_handler', $this->object);
    }


    public function testSave_new_text()
    {
        foreach (\App\classes\CommentClasses\dao\StockTextDao::$valences as $valence) {
            $text = 'test stock text';
            $expect = $valence . ' ' . $text;
            $expect_obj = new \StockText();
            $expect_obj->setContent($expect);

            $this->cleaner->set_response($text);
            $this->object->load_cleaner($this->cleaner);
            $this->object->set_response_handler($this->handler);

            $this->dao->set_response($expect_obj);
            $this->object->setDao($this->dao);

            $result = $this->object->save_new_text($text, $valence);

            $this->assertInstanceOf('\StockText', $result);
            $this->assertEquals('sanitize', $this->cleaner->called);
            $this->assertEquals('handle_row_count', $this->handler->called);
            $this->assertEquals(1, $this->handler->called_list[0][1][0]);

            $this->assertEquals($expect_obj, $result);
        }




    }

//    public function testCheck_valence()
//    {
//        foreach(StockTextProcessor::$valences as $v){
//            $this->assertTrue($this->object->check_valence($v));
//        }
//        $this->assertFalse($this->object->check_valence('housecat'));
//    }
}
