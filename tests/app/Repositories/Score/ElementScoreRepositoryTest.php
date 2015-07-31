<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:08 AM
 */

namespace App\Repositories\Score;


class ElementScoreRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementScoreRepository;
    }


    public function testLoad()
    {
        $this->markTestIncomplete();
//        $elementAssignmentId, $studentId
//        $this->score_object = ElementScore::onStudentElementAssignment($studentId, $elementAssignmentId)->first();

//        return $this->score_object;
    }


    public function testLoad_all_for_question_number()
//IQuestionAssignmentRepository $questionAssigner, $examId, $questionNumber)
    {
        $this->markTestIncomplete();
//        $assignment = $questionAssigner->load($examId, $questionNumber);
//        ElementScore::whereHas('questionAssignment', function($query, $assignment){
//            $query->where('id', $assignment->getId());
//        });
    }


    public function testLoad_for_student_on_exam()
    {
        $this->markTestIncomplete();
    }


    public function testUpdate()
    {
//        $elementAssignmentId, $studentId, $score
        $this->markTestIncomplete();
    }


}
