<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/25/15
 * Time: 11:13 AM
 */

namespace App;


class QuestionUpdateDoesNotDeleteStudentScores extends \TestCase
{
    public static $examId = 1;
    protected $object;
    protected $assignments;
    protected $exam;
    protected $scores;

    public function setUp()
    {
        parent::setUp();
        $this->exam = Exam::find(self::$examId);
        $this->assignments = QuestionAssignment::where('exam_id', self::$examId)->get();
        $this->scores = [];
        foreach($this->assignments as $assign)
        {
            $scores = QuestionScore::where('question_assignment_id', $assign->getId());
            foreach($scores as $score)
            {
                $this->scores[] = $score;
            }
        }
    }


}