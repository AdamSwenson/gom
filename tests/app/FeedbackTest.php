<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/27/15
 * Time: 1:34 PM
 */

namespace App;


class FeedbackTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Feedback;
    }


    /**
     * @test
     */
    public function getQuestionNumbers()
    {
        $f = Feedback::all()->random();
        $this->assertTrue(! is_null($f), "Object returned");
        $this->assertInstanceOf(Feedback::class, $f, "Feedback object returned");
        $r = $f->getQuestionNumbers();
        $this->assertTrue(is_array($r), "Array returned");
        $this->assertNotEmpty($r, "The returned array is non empty");
        foreach($r as $a){
            $this->assertTrue(is_numeric($a), "The array contains numbers");
        };
    }
}
