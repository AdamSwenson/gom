<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/28/15
 * Time: 8:24 PM
 */

namespace App\classes\SecurityClasses\cleaning;


class FloatCleanerTest extends \TestCase {

    protected $object;


    public function setUp()
    {
        parent::setUp();
        $this->object = new FloatCleaner();
    }

    /**
     * @covers \App\classes\SecurityClasses\cleaning\FloatCleaner::sanitize
     */
    public function testSanitize()
    {
        $this->assertEquals(9.3, $this->object->sanitize(9.3));
        $this->assertEquals(9.3, $this->object->sanitize('9.3'));
    }

    /**
     * @expectedException \App\Exceptions\InputTypeException
     */
    public function testSanitizeExceptionTooBig()
    {
        $test = 10.98;
        $this->object->sanitize($test, 10);
    }

    /**
     * @expectedException \App\Exceptions\InputTypeException
     */
    public function testSanitizeExceptionNonNumeric()
    {
        $this->object->sanitize('taco');
    }




    /**
     * @covers \App\classes\SecurityClasses\cleaning\FloatCleaner::validate
     */
    public function testValidate()
    {
        $this->assertEquals(9.3, $this->object->validate(9.3));
        $this->assertEquals(9.3, $this->object->validate('9.3'));

    }



    /**
     * @covers \App\classes\SecurityClasses\cleaning\FloatCleaner::set_max_length
     */
    public function testSet_max_length()
    {
        $this->object->set_max_length(45);
        $this->assertAttributeEquals(45, 'max_length', $this->object);
    }

}
