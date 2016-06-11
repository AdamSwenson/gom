<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/26/15
 * Time: 3:13 PM
 */

namespace functional;

use App\Exam;
use App\QuestionAssignment;
use App\QuestionScore;

/**
 * Tests that requests create the expected database changes
 *
 * @package functional
 */
class QuestionControllerEndToEnd extends \TestCase
{
//    static public $examId = 1;
//    public $exam;
//    public $questions;
//    public $questionAssignments;
//    public $questionScores;
//
//
//    public function setUp()
//    {
//        parent::setUp();
//
//        $this->exam = Exam::where('id', self::$examId)->first();
//        $this->questionAssignments = QuestionAssignment::where('exam_id', self::$examId)->get();
//        $this->questionScores = QuestionScore::all();
//        foreach ($this->questionAssignments as $qa)
//        {
//            $this->questions[] = $qa->getQuestion();
//        }
//        $this->target = "/exam/{$this->exam->getId()}/question/updateAll";
//
//    }
//
//    public function buildOriginalData()
//    {
//        $data = [];
//        $i = 1;
//        foreach ($this->questionAssignments as $qa)
//        {
//            $question = $qa->getQuestion();
//            $data[] = [
//                "questionId{$i}" => $question->id,
//                "questionName{$i}" => $question->getQuestionName(),
//                "questionText{$i}" => $question->getQuestionText(),
//                "maxScore{$i}" => $question->getMaxScore()
//            ];
//            $i++;
//        }
//
//        return $data;
//    }
//
//    public function checkQuestionScoresNoChange()
//    {
//        //Check question scores table
//        foreach ($this->questionScores as $qs)
//        {
//            $score = QuestionScore::find($qs->id);
//            $this->assertNotEmpty($score);
//            $this->assertEquals($qs->question_assignment_id, $score->question_assignment_id);
//            $this->assertEquals($qs->student_id, $score->student_id);
//            $this->assertEquals($qs->score, $score->score);
//        }
//    }
//
//    public function checkAssignmentsNoChange()
//    {
//        //Check question assignment table
//        foreach ($this->questionAssignments as $qa)
//        {
//            $this->seeInDatabase('question_assignments', [
//                'id' => $qa->id,
//                'exam_id' => self::$examId,
//                'question_id' => $qa->question_id,
//                'question_number' => $qa->question_number
//            ]);
//        }
//    }
//
//    public function checkQuestionsNoChange()
//    {
////Check questions table
//        foreach ($this->questions as $q)
//        {
//            $this->seeInDatabase('questions', [
//                                                'id' => $q->id,
//                                                'questionName' => $q->getQuestionName(),
//                                                'questionText' => $q->getQuestionText(),
//                                                'max_score' => $q->getMaxScore()
//                                            ]
//            );
//        }
//    }
//
//    /**
//     * Simulates a submission with no alterations
//     * @test
//     */
//    public function noChanges()
//    {
//        //prep
////        $target = "/exam/{$this->exam->getId()}/question/updateAll";
//        $data = $this->buildOriginalData();
//        //call
//        $response = $this->call('POST', $this->target, $data);
//        //check
//        $this->assertNotEmpty($response);
//        $this->checkQuestionsNoChange();
//        $this->checkAssignmentsNoChange();
//        $this->checkQuestionScoresNoChange();
//    }
//
//    /**
//     * Simulates renaming existing questions with no other changes to order.
//     * @test
//     */
//    public function alterationsToQuestionNamesNoChangeToOrder()
//    {
//        $newQuestionName = 'test string';
//
//        //prep
//        $data = [];
//        $i = 1;
//        foreach ($this->questionAssignments as $qa)
//        {
//            $question = $qa->getQuestion();
//            $data[] = [
//                "questionId{$i}" => $question->id,
//                "questionName{$i}" => $newQuestionName,
//                "questionText{$i}" => $question->getQuestionText(),
//                "maxScore{$i}" => $question->getMaxScore()
//            ];
//            $i++;
//        }
//
//        //call
//        $response = $this->call('POST', $this->target, $data);
//
//        //check
//        $this->assertNotEmpty($response);
//        $this->checkAssignmentsNoChange();
//        $this->checkQuestionScoresNoChange();
//        foreach ($this->questions as $q)
//        {
//            $this->seeInDatabase('questions',
//                                 [
//                                     'id' => $q->id,
//                                     'questionName' => $newQuestionName,
//                                     'questionText' => $q->getQuestionText(),
//                                     'max_score' => $q->getMaxScore()
//                                 ]
//            );
//        }
//    }
//
//    /**
//     * Simulates adding a new question to the end of the list of questions.
//     * Thus the questions and question_assignments tables will be updated
//     * but pre-existing items and scores won't be touched.
//     * @test
//     */
//    public function additionToEndNoChangeToOrder()
//    {
//        $testName = 'taco';
//        $testText = 'are delicious';
//        $testMax = 200;
//        //prep
//        $newQnum = count($this->questionAssignments) + 2;
//        $data = $this->buildOriginalData();
//        $data[] = ["questionId{$newQnum}" => 0,
//        "questionName{$newQnum}" => $testName,
//        "questionText{$newQnum}" => $testText,
//        "maxScore{$newQnum}" => $testMax];
//
//        //call
//       // $target = "/exam/{$this->exam->getId()}/question/edit";
//        $response = $this->call('POST', $this->target, $data);
//
//        //check
//        $this->assertNotEmpty($response);
//        $this->checkAssignmentsNoChange();
//        $this->checkQuestionScoresNoChange();
//        $this->checkQuestionsNoChange(); //Other questions not affected
//        //Check added to questions
//        $this->seeInDatabase('questions', [
//            'questionName' => $testName,
//            'questionText' => $testText,
//            'max_score' => $testMax
//        ]);
//        //Check added to assignments
//        $this->seeInDatabase('question_assignments', [
//            'exam_id' => self::$examId,
//            'question_number' => $newQnum]);
//
//    }
//
//    public
//    function additionToMiddleNoOtherChangeToOrder()
//    {
//    }
//
//    public function deletionNoOtherChangeToOrder()
//    {
//    }
//
//
//    public function reorderNoOtherChanges()
//    {
//    }
//
//    public function deleteQuestionAlterDifferentQuestionNameReorderRemaining()
//    {
//    }
}