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

    public function testGetQuestionName()
    {
        //prep
        $qid = $this->assignment->question_id;
        $question = Question::where('id', $qid)->first();
        $qName = $question->getQuestionName();

        //call
        $result = $this->assignment->getQuestionName();

        //check
        $this->assertEquals($qName, $result);
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


    public function testElementAssignments()
    {
        foreach($this->assignment->elementAssignments() as $ea)
        {
            $this->assertInstanceOf('App\ElementAssignment', $ea);
        }
    }

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
