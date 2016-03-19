<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/18/16
 * Time: 4:48 PM
 */

namespace App\Jobs\AsyncStorage;

use App\Exam;
use App\Repositories\Exam\INumberGradedRepository;
use App\Repositories\Exam\StoredExamStatsRepository;
use App\Repositories\Student\StudentRepository;
use Faker\Factory;
use Mockery\Mock;

class UpdateStoredNumGradedTest extends \TestCase
{
    protected $object;
    protected $exam;
    protected $questionAssignmentRepository;
    protected $numGradedRepository;


    public function setUp()
    {
        parent::setUp();
        $this->exam = Exam::all()->random();
    }

    public function tearDown()
    {
        \Mockery::close();
    }


    /** @test*/
    public function updateGradedStudentsWhereStoredEqualsCalc()
    {
        $total = Factory::create()->randomNumber();
        $numGradedDao = \Mockery::mock(INumberGradedRepository::class);

        $numGradedDao
            ->shouldReceive('calculateNumberGradedFromMySQL')
            ->once()
            ->with($this->exam)
            ->andReturn($total);

        $numGradedDao
            ->shouldReceive('getNumberGraded')
            ->once()
            ->with($this->exam)
            ->andReturn($total);

        $numGradedDao
            ->shouldNotReceive('addGradedStudents');

        $this->registerMock(INumberGradedRepository::class, $numGradedDao);

        $object = new UpdateStoredNumGraded($this->exam);
        $object->updateGradedStudents();
    }

    /** @test */
    public function updateGradedStudentsWhereStoredNotEqualsCalc()
    {
        $total = Factory::create()->randomNumber();
        $storedTotal = $total + 5;
        $numGradedDao = \Mockery::mock(INumberGradedRepository::class);

        $numGradedDao
            ->shouldReceive('calculateNumberGradedFromMySQL')
            ->once()
            ->with($this->exam)
            ->andReturn($total);

        $numGradedDao
            ->shouldReceive('getNumberGraded')
            ->once()
            ->with($this->exam)
            ->andReturn($storedTotal);

        $numGradedDao
            ->shouldReceive('addGradedStudents')
            ->once()
            ->with($this->exam, $total, true);

        $this->registerMock(INumberGradedRepository::class, $numGradedDao);

        $object = new UpdateStoredNumGraded($this->exam);
        $object->updateGradedStudents();
    }
}
