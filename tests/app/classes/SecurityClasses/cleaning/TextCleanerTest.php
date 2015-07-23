<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/23/15
 * Time: 8:34 AM
 */

namespace App\classes\SecurityClasses\cleaning;


class TextCleanerTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new TextCleaner;
    }

    public function testSanitize()
    {
        $this->assertEquals('string trimmed.', $this->object->sanitize('  string trimmed.  '), "trims string");
        $this->assertEquals('string trimmed.', $this->object->sanitize('string <script>trimmed.  '), "strips tags");
    }

    /**
     * @expectedException \App\Exceptions\InputTypeException
     */
    public function testSanitizeExceptionOnTooLong()
    {
        $test = "abcdef";
        $maxlen = mb_strlen($test) -1 ;
        $this->object->sanitize($test, $maxlen);
    }

    public function testValidate()
    {
        $test = "abcdef";
        $this->assertEquals($test, $this->object->validate($test));
    }

}
