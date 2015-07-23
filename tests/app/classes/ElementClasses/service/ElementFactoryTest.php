<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 1:39 PM
 */

namespace App\classes\ElementClasses\service;


use App\classes\RequestClasses\IRequestMock;
use App\classes\SecurityClasses\cleaning\ICleanerFactoryMock;

class ElementFactoryTest extends \TestCase
{


    public $request;
    public $object;
    public $cleaner;

    public function setUp()
    {
        parent::setUp();
        $this->cleaner = new ICleanerFactoryMock();
        $this->object = new ElementFactory();
        $this->request = new IRequestMock();
    }

    /**
     * @covers App\classes\ElementClasses\service\ElementFactory::set_cleaner
     */
    public function testSet_cleaner()
    {
        $this->object->set_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('App\classes\SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }

    /**
     * @covers App\classes\ElementClasses\service\ElementFactory::load
     */
    public function testLoad()
    {
        $this->object->set_cleaner($this->cleaner);
        $this->request->http = array('elementID' => 1);
        $result = $this->object->load($this->request);
        $this->assertInstanceOf('\Element', $result);
    }


}
