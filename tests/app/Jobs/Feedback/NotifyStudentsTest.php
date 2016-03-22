<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/2/15
 * Time: 1:48 PM
 */

namespace Jobs\Feedback;


class NotifyStudentsTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new NotifyStudentsTest;
    }

    /**
     * @test
     */
    public function students_who_have_not_been_graded_should_not_receive_email()
    {
        $this->markTestIncomplete();
    }

}
