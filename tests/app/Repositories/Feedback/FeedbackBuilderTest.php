<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 6:22 PM
 */

namespace App\Repositories\Feedback;


class FeedbackBuilderTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new FeedbackBuilder;

        $examName = 'text';
        $grade = 'F-';

        $studentArray = [];

        $questions = ['q1', 'q2'];

        $questionNumber = '';
        $questionTitle = '';
        $commentsArray = '';

    }


    public function testBuildTopLevelContent()
    {
//        &$studentArray, $examName, $grade

    }
    public function testBuildQuestion()
    {
        //&$studentArray, $questionNumber, $questionTitle, $commentsArray
    }

}
