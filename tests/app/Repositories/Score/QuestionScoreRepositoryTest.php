<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:09 AM
 */

namespace Repositories\Score;


class QuestionScoreRepositoryTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new QuestionScoreRepositoryTest;
    }

    public function testLoad_for_student_on_exam()
    {
//        $examId, $studentId
    }

    public function testLoad_all_for_question_number()
    {
//        $examId, $questionNumber
        $this->markTestIncomplete();
    }


    public function testLoad()
    {
        $this->markTestIncomplete();
//        $questionAssignmentId, $studentId
//
//        $this->score_object = QuestionScore::onStudentQuestionAssignment($studentId, $questionAssignmentId)->first();
//        return $this->score_object;
    }

    public function testUpdate()
    {
//        $questionAssignmentId, $studentId, $score
        $this->markTestIncomplete();
    }
}
