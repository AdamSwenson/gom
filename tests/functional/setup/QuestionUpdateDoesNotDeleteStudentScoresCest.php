<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/25/15
 * Time: 11:13 AM
 */

namespace App;

class QuestionUpdateDoesNotDeleteStudentScoresCest
{

    public static $examId = 1;
    protected $object;
    protected $assignments;
    protected $exam;
    protected $scores;


    public function _before(FunctionalTester $I)
    {
//        $this->exam = Exam::find(self::$examId);
//        $this->assignments = QuestionAssignment::where('exam_id', self::$examId)->get();
//        $this->scores = [];
//        foreach($this->assignments as $assign)
//        {
//            $scores = QuestionScore::where('question_assignment_id', $assign->getId());
//            foreach($scores as $score)
//            {
//                $this->scores[] = $score;
//            }
//        }

    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {

    }
}