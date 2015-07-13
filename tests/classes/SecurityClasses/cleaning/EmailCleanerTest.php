<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/29/15
 * Time: 9:44 PM
 */

namespace SecurityClasses\cleaning;


class EmailCleanerTest extends \PHPUnit_Framework_TestCase {

    protected $object; 
    
    protected function setUp()
    {
        parent::setUp();
        $this->object = new EmailCleaner;
    }

    /**
     * @covers \SecurityClasses\cleaning\EmailCleaner::sanitize
     */
    public function testSanitize() {
        $dirty = 'testemail@email.com';
        $this->assertEquals('testemail@email.com', $this->object->sanitize($dirty));
    }

    /**
     * @covers \SecurityClasses\cleaning\EmailCleaner::sanitize
     */
    public function testSanitize_invalid_address()
    {
        $this->assertFalse($this->object->sanitize(' \testemail@email '));
        $this->assertFalse($this->object->sanitize(''));
        $this->assertFalse($this->object->sanitize('4'));
        $this->assertFalse($this->object->sanitize(44444444));
    }

    /**
     * TODO: Add test for greater than max length
     * @covers \SecurityClasses\cleaning\EmailCleaner::validate
     */
    public function testValidate() {
        $this->assertFalse($this->object->validate(' \testemail@email '));
        $this->assertFalse($this->object->validate(''));
        $this->assertFalse($this->object->validate('4'));
        $this->assertFalse($this->object->validate(44444444));

    }

    /**
     * @covers \SecurityClasses\cleaning\EmailCleaner::set_max_length
     */
    public function testSet_max_length() {
        $this->object->set_max_length(34);
        $this->assertAttributeEquals(34, 'max_length', $this->object);
    }

}
