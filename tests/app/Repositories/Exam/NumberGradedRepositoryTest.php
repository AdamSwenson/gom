<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/18/16
 * Time: 1:45 PM
 */

namespace App\Repositories\Exam;


use App\Exam;
use App\Repositories\Exam\NumberGradedRepository;
use Illuminate\Support\Facades\Redis;

class NumberGradedRepositoryTest extends \BrowserKitTestCase
{

    protected $object;
    protected $exam;
    protected $key;

    public function setUp()
    {
        parent::setUp();
        $this->object = new NumberGradedRepository;

        $this->exam = Exam::all()->random();

        $this->key = NumberGradedRepository::KEY_BASE . $this->exam->id;
    }

    /** @test */
    public function getNumberGraded()
    {
        Redis::shouldReceive('exists')
            ->once()
            ->with($this->key)
            ->andReturn(true);

        Redis::shouldReceive('get')
            ->once()
            ->with($this->key)
            ->andReturn(5);

        $this->object->getNumberGraded($this->exam);
    }

    /** @test */
    public function updateNumberGradedByOne()
    {
        //prep
        $returnValue = 5;
        Redis::shouldReceive('incr')
            ->once()
            ->with($this->key)
            ->andReturn($returnValue);

        //call
        $result = $this->object->updateNumberGradedByOne($this->exam);

        //check
        $this->assertTrue($result, "returns expected value");
    }

    /** @test */
    public function addGradedStudentsWithResetFalse()
    {
        //prep
        $numStudents = \Faker\Factory::create()->randomDigit();
        Redis::shouldReceive('incrby')
            ->once()
            ->with($this->key, $numStudents)
            ->andReturn(true);

        //call
        $result = $this->object->addGradedStudents($this->exam, $numStudents);

        //check
        $this->assertTrue($result, "returns expected value");
    }
    /** @test */
    public function addGradedStudentsWithResetTrue()
    {
        //prep
        $numStudents = \Faker\Factory::create()->randomDigit();
        Redis::shouldReceive('set')
            ->once()
            ->with($this->key, 0)
            ->andReturn(true);

        Redis::shouldReceive('incrby')
            ->once()
            ->with($this->key, $numStudents)
            ->andReturn(true);

        //call
        $result = $this->object->addGradedStudents($this->exam, $numStudents, true);

        //check
        $this->assertTrue($result, "returns expected value");
    }


    /** @test */
    public function deleteExamRecords(){
        //prep
        Redis::shouldReceive('del')
            ->once()
            ->with($this->key)
            ->andReturn(true);

        //call
        $result = $this->object->deleteExamRecords($this->exam);

        //check
        $this->assertTrue($result, "returns expected value");
    }


}
