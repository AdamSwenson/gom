<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/29/15
 * Time: 9:44 PM
 */

namespace App\classes\SecurityClasses\cleaning;


class EmailCleanerTest extends \TestCase {

    protected $object; 
    
    public function setUp()
    {
        parent::setUp();
        $this->object = new EmailCleaner;
    }

    /**
     * @covers \App\classes\SecurityClasses\cleaning\EmailCleaner::sanitize
     */
    public function testSanitize() {
        $dirty = 'testemail@email.com';
        $this->assertEquals('testemail@email.com', $this->object->sanitize($dirty));
    }


    /**
     * @expectedException \App\Exceptions\InputTypeException
     * @covers \App\classes\SecurityClasses\cleaning\EmailCleaner::sanitize
     */
    public function testSanitize_invalid_addressExceptionEmptyString()
    {
        $this->object->sanitize('');
    }

    /**
     * @expectedException \App\Exceptions\InputTypeException
     * @covers \App\classes\SecurityClasses\cleaning\EmailCleaner::sanitize
     */
    public function testSanitize_invalid_addressExceptionIntegerInsteadOfAdress()
    {
        $this->object->sanitize(44444444);
    }

    /**
     * @expectedException \App\Exceptions\InputTypeException
     * @covers \App\classes\SecurityClasses\cleaning\EmailCleaner::sanitize
     */
    public function testSanitize_invalid_addressExceptionBadAddress()
    {
        $this->object->sanitize(' \testemail@email ');
    }

    /**
     * TODO: Add test for greater than max length
     * @covers \App\classes\SecurityClasses\cleaning\EmailCleaner::validate
     */
    public function testValidate() {
        $this->assertFalse($this->object->validate(' \testemail@email '));
        $this->assertFalse($this->object->validate(''));
        $this->assertFalse($this->object->validate('4'));
        $this->assertFalse($this->object->validate(44444444));

    }

    /**
     * @covers \App\classes\SecurityClasses\cleaning\EmailCleaner::set_max_length
     */
    public function testSet_max_length() {
        $this->object->set_max_length(34);
        $this->assertAttributeEquals(34, 'max_length', $this->object);
    }

}
