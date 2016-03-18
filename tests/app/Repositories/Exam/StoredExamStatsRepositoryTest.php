<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/18/16
 * Time: 2:31 PM
 */

namespace App\Repositories\Exam;


use App\Exam;
use Faker\Factory;
use Illuminate\Support\Facades\Redis;

class StoredExamStatsRepositoryTest extends \TestCase
{

    protected $object;
    protected $exam;
    protected $key;
    protected $questionsKey;
    protected $studentsKey;


    public function setUp()
    {
        parent::setUp();
        $this->object = new StoredExamStatsRepository;
        $this->exam = Exam::all()->random();

        $this->studentsKey = StoredExamStatsRepository::STUDENTS_KEY_BASE . $this->exam->id;
        $this->questionsKey = StoredExamStatsRepository::QUESTIONS_KEY_BASE . $this->exam->id;
    }


    /** @test */
    public function getNumberStudents()
    {
        //prep
        $expectedNumber = Factory::create()->randomNumber();
        Redis::shouldReceive('exists')
            ->once()
            ->with($this->studentsKey)
            ->andReturn(true);

        Redis::shouldReceive('get')
            ->once()
            ->with($this->studentsKey)
            ->andReturn($expectedNumber);

        //call
        $result = $this->object->getNumberStudents($this->exam);

        //check
        $this->assertEquals($expectedNumber, $result, "Expected number returned");
    }

    /** @test */
    public function getNumberQuestions()
    {
        //prep
        $expectedNumber = Factory::create()->randomNumber();
        Redis::shouldReceive('exists')
            ->once()
            ->with($this->questionsKey)
            ->andReturn(true);

        Redis::shouldReceive('get')
            ->once()
            ->with($this->questionsKey)
            ->andReturn($expectedNumber);

        //call
        $result = $this->object->getNumberQuestions($this->exam);

        $this->assertEquals($expectedNumber, $result, "Expected number returned");
    }

    /** @test */
    public function updateNumberQuestionsByOne()
    {
        //prep
        Redis::shouldReceive('incr')
            ->once()
            ->with($this->questionsKey);

        //call
        $result = $this->object->updateNumberQuestionsByOne($this->exam);

        //check
        $this->assertTrue($result, "returns expected value");
    }

    /** @test */
    public function updateNumberStudentsByOne()
    {
        //prep
        Redis::shouldReceive('incr')
            ->once()
            ->with($this->studentsKey);

        //call
        $result = $this->object->updateNumberStudentsByOne($this->exam);

        //check
        $this->assertTrue($result, "returns expected value");
    }

    /** @test */
    public function addQuestionsWithResetFalse()
    {
        //prep
        $numQuestions = Factory::create()->randomDigit();
        Redis::shouldReceive('incrby')
            ->once()
            ->with($this->questionsKey, $numQuestions)
            ->andReturn(true);

        //call
        $result = $this->object->addQuestions($this->exam, $numQuestions);

        //check
        $this->assertTrue($result, "returns expected value");
    }

    /** @test */
    public function addQuestionsWithResetTrue()
    {
        //prep
        $numQuestions = Factory::create()->randomDigit();
        Redis::shouldReceive('set')
            ->once()
            ->with($this->questionsKey, 0)
            ->andReturn(true);

        Redis::shouldReceive('incrby')
            ->once()
            ->with($this->questionsKey, $numQuestions)
            ->andReturn(true);

        //call
        $result = $this->object->addQuestions($this->exam, $numQuestions, true);

        //check
        $this->assertTrue($result, "returns expected value");
    }

    /** @test */
    public function addStudentsWithResetFalse()
    {
        //prep
        $numStudents = Factory::create()->randomDigit();
        Redis::shouldReceive('incrby')
            ->once()
            ->with($this->studentsKey, $numStudents)
            ->andReturn(true);

        //call
        $result = $this->object->addStudents($this->exam, $numStudents);

        //check
        $this->assertTrue($result, "returns expected value");
    }

    /** @test */
    public function addStudentsWithResetTrue()
    {
        //prep
        $numStudents = Factory::create()->randomNumber();
        Redis::shouldReceive('set')
            ->once()
            ->with($this->studentsKey, 0)
            ->andReturn(true);

        Redis::shouldReceive('incrby')
            ->once()
            ->with($this->studentsKey, $numStudents)
            ->andReturn(true);

        //call
        $result = $this->object->addStudents($this->exam, $numStudents, true);

        //check
        $this->assertTrue($result, "returns expected value");
    }

    /** @test */
    public function deleteExamRecords()
    {
        //prep
        Redis::shouldReceive('del')
            ->once()
            ->with($this->questionsKey)
            ->andReturn(true);

        Redis::shouldReceive('del')
            ->once()
            ->with($this->studentsKey)
            ->andReturn(true);

        //call
        $result = $this->object->deleteExamRecords($this->exam);

        //check
        $this->assertTrue($result, "returns expected value");
    }

}
