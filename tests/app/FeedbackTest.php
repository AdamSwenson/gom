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
        $this->object = factory(Feedback::class)->create();
    }


    /**
     * @test
     */
    public function getQuestionNumbers()
    {
        #call
        $r = $this->object->getQuestionNumbers();

        #check
        $this->assertTrue(is_array($r), "Array returned");
        $this->assertNotEmpty($r, "The returned array is non empty");
        foreach($r as $a){
            $this->assertTrue(is_numeric($a), "The array contains numbers");
        };
    }


    /** @test */
    public function grade(){
        #prep
        $expect = $this->object->grade_display;

        #call
        $result = $this->object->grade();

        #check
        $this->assertEquals($expect, $result, "expected grade returned");
    }


    /** @test */
    public function gradeWhereNoneAssigned(){
        #prep
        $this->object->grade_display = null;
        $expect = Feedback::NO_GRADE;

        #call
        $result = $this->object->grade();

        #check
        $this->assertEquals($expect, $result, "expected grade placeholder returned");
    }

    /** @test */
    public function gradeValue()
    {
        #prep
        $expect = $this->object->grade_calc;

        #call
        $result = $this->object->gradeValue();

        #check
        $this->assertEquals($expect, $result, "expected grade value returned");
    }

    /** @test */
    public function getAccessKey()
    {
        #prep
        $expect = $this->object->access_key;

        #call
        $result = $this->object->getAccessKey();

        #check
        $this->assertEquals($expect, $result, "expected access key value returned");

    }

    /** @test */
    public function getAccessKeyAsProperty()
    {
        #prep
        $expect = $this->object->access_key;

        #call
        $result = $this->object->accessKey;

        #check
        $this->assertEquals($expect, $result, "expected access key value returned");

    }



}
