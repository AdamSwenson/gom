<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 1:39 PM
 */

namespace ElementClasses\service;


use RequestClasses\IRequestMock;
use SecurityClasses\cleaning\ICleanerFactoryMock;

class ElementFactoryTest extends \PHPUnit_Framework_TestCase
{


    public $request;
    public $object;
    public $cleaner;

    protected function setUp()
    {
        parent::setUp();
        $this->cleaner = new ICleanerFactoryMock();
        $this->object = new ElementFactory();
        $this->request = new IRequestMock();
    }

    /**
     * @covers ElementClasses\service\ElementFactory::set_cleaner
     */
    public function testSet_cleaner()
    {
        $this->object->set_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }

    /**
     * @covers ElementClasses\service\ElementFactory::load
     */
    public function testLoad()
    {
        $this->object->set_cleaner($this->cleaner);
        $this->request->http = array('elementID' => 1);
        $result = $this->object->load($this->request);
        $this->assertInstanceOf('\Element', $result);
    }


}
