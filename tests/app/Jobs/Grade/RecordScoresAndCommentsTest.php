<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/30/16
 * Time: 4:27 PM
 */

namespace App\Jobs\Grade;


class RecordScoresAndCommentsTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new RecordScoresAndComments;
    }

//    public function testRecordScoreQuestion()
//    {
//        $data = ['examId' => 1, 'question_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];
//        $mock = $this->createMock('App\Repositories\Score\IQuestionScoreRepository');
//        $mock->shouldReceive('record')
//            ->with([$data['question_assignment_id'], $data['student_id'], $data['score']])
//            ->andReturn(QuestionScore::all()->random());
//        $response = $this->action('POST', 'GradeController@recordScore', $data);
//        $this->assertNotNull($response);
//    }

    /*    public function testRecordScoreElement()
        {
            $data = ['examId' => 1, 'element_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];
            $mock = $this->createMock('App\Repositories\Score\IElementScoreRepository');
            $mock->shouldReceive('record')
                ->with([$data['element_assignment_id'], $data['student_id'], $data['score']])
                ->andReturn(ElementScore::all()->random());
            $response = $this->action('POST', 'GradeController@recordScore', $data);
            $this->assertNotNull($response);
        }*/

    /*
    public function testRecordScoreUnset()
    {
    }
    */

}
