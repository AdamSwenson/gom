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
        $r = $f->getQuestionNumbers();
        foreach($r as $a){
            $this->assertTrue(is_numeric($a));
        };
    }
}
