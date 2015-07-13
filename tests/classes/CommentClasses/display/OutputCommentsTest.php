<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/3/15
 * Time: 10:42 AM
 */

namespace CommentClasses\display;


class OutputCommentsTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new OutputComments;
    }

    public function testSet_encoder()
    {
        $enc = new \JsonOutputClasses\encoders\DirectJsonOutput();
        $this->object->set_encoder($enc);
        $this->assertAttributeInstanceOf('\JsonOutputClasses\encoders\DirectJsonOutput', 'encoder', $this->object);
    }
}
