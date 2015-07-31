<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/29/15
 * Time: 1:49 PM
 */

namespace App;


class QuestionAssignmentTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionAssignment;
        $this->assignment = QuestionAssignment::all()->random();
    }

//    public function scopeOnExam($query, $examId)
//    {
//        return $query->whereExamId($examId);
//    }
//
//    public function scopeOnQuestionId($query, $questionId)
//    {
//        return $query->whereQuestionId($questionId);
//    }
//
//    public function scopeQuestionNumber($query, $questionNumber)
//    {
//        $s = $this->assignment->toArray();
//        $this->assertNotEmpty($this->assignment->)
//        return $query->whereQuestionNumber($questionNumber);
//    }

# -------------- Foreign key associations
//    public function testUser()
//    {
//        $this->assertInstanceOf('App\User', $this->assignment->user);
//    }

    public function testExam()
    {
        foreach($this->assignment->exam as $e)
        {
            $this->assertInstanceOf('App\Exam', $e);
        }
    }

    public function testQuestion()
    {
        foreach ($this->assignment->question as $q)
        {
            $this->assertInstanceOf('App\Question', $q);
        }
    }

    public function testQuestionScores()
    {
        foreach ($this->assignment->questionScores as $q)
        {
            $this->assertInstanceOf('App\QuestionScore', $q);
        }
    }


}
