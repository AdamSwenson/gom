<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/3/15
 * Time: 10:42 AM
 */

namespace App\classes\CommentClasses\display;


use App\classes\JsonOutputClasses\encoders\DirectJsonOutput;

class OutputCommentsTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new OutputComments;
    }

    public function testSet_encoder()
    {
        $enc = new DirectJsonOutput();
        $this->object->set_encoder($enc);
        $this->assertAttributeInstanceOf('\App\classes\JsonOutputClasses\encoders\DirectJsonOutput', 'encoder', $this->object);
    }
}
