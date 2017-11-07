<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/18/16
 * Time: 3:24 PM
 */

namespace App\Jobs\AsyncStorage;


use App\Exam;
use App\Repositories\Exam\StoredExamStatsRepository;
use App\Repositories\Student\StudentRepository;
use Faker\Factory;
use Mockery\Mock;

class UpdateStoredExamStatsTest extends \TestCase
{

    protected $object;
    protected $exam;
    protected $questionAssignmentRepository;
    protected $storedExamStatsRepository;

    public function setUp()
    {
        parent::setUp();
        $this->exam = Exam::all()->random();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function updateQuestionsWhereStoredEqualsCurrent()
    {
        $numQuestions = 5;

        $qar = \Mockery::mock('App\Repositories\Question\IQuestionAssignmentRepository');
        $qar->shouldReceive('load_all_for_exam')
            ->once()
            ->with($this->exam->id)
            ->andReturn([1, 2, 3, 4, 5]);
        $this->registerMock('App\Repositories\Question\IQuestionAssignmentRepository', $qar);

        $ser = \Mockery::mock('App\Repositories\Exam\IStoredExamStatsRepository');
        $ser->shouldReceive('getNumberQuestions')
            ->once()
            ->with($this->exam)
            ->andReturn($numQuestions);
        $ser->shouldNotReceive('addQuestions');
        $this->registerMock('App\Repositories\Exam\IStoredExamStatsRepository', $ser);

        $this->object = new UpdateStoredExamStats($this->exam);

        //call
        $this->object->updateQuestions();
    }

    /** @test */
    public function updateQuestionsWhereStoredNotEqualsCurrent()
    {
        $questionsArray = [1, 2];
        $numQuestions = 5;

        $qar = \Mockery::mock('App\Repositories\Question\IQuestionAssignmentRepository');
        $qar->shouldReceive('load_all_for_exam')
            ->once()
            ->with($this->exam->id)
            ->andReturn($questionsArray);
        $this->registerMock('App\Repositories\Question\IQuestionAssignmentRepository', $qar);

        $ser = \Mockery::mock('App\Repositories\Exam\IStoredExamStatsRepository');
        $ser->shouldReceive('getNumberQuestions')
            ->once()
            ->with($this->exam)
            ->andReturn($numQuestions);
        $ser->shouldReceive('addQuestions')->once()->with($this->exam, sizeof($questionsArray), true);
        $this->registerMock('App\Repositories\Exam\IStoredExamStatsRepository', $ser);

        $this->object = new UpdateStoredExamStats($this->exam);

        //call
        $this->object->updateQuestions();
    }



    /** @test */
    public function updateStudentsWhereStoredEqualsCurrent()
    {

        $numStudents = 5;
        $statsDao = \Mockery::mock(StoredExamStatsRepository::class);
        $studentDao = \Mockery::mock(StudentRepository::class);

        $studentDao
            ->shouldReceive('load_students_by_exam')
            ->once()
            ->with($this->exam->id)
            ->andReturn([1, 2, 3, 4, 5]);

        $statsDao
            ->shouldReceive('getNumberStudents')
            ->once()
            ->with($this->exam)
            ->andReturn($numStudents);

        $statsDao->shouldNotReceive('addStudents');

        $this->registerMock(StoredExamStatsRepository::class, $statsDao);
        $this->registerMock(StudentRepository::class, $studentDao);


        $this->object = new UpdateStoredExamStats($this->exam);
        $this->assertAttributeInstanceOf(Exam::class, 'exam1', $this->object, 'exam1 set for testing');

        //call
        $this->object->updateStudents();
    }

    /** @test */
    public function updateStudentsWhereStoredNotEqualsCurrent()
    {
        $studentsArray = [1, 2];
        $numStudents = 5;
        $statsDao = \Mockery::mock(StoredExamStatsRepository::class);
        $studentDao = \Mockery::mock(StudentRepository::class);

        $studentDao
            ->shouldReceive('load_students_by_exam')
            ->once()
            ->with($this->exam->id)
            ->andReturn($studentsArray);

        $statsDao
            ->shouldReceive('getNumberStudents')
            ->once()
            ->with($this->exam)
            ->andReturn($numStudents);

        $statsDao->shouldReceive('addStudents')
            ->once()
            ->with($this->exam, sizeof($studentsArray), true);

        $this->registerMock(StoredExamStatsRepository::class, $statsDao);
        $this->registerMock(StudentRepository::class, $studentDao);

        $this->object = new UpdateStoredExamStats($this->exam);
        $this->assertAttributeInstanceOf(Exam::class, 'exam1', $this->object, 'exam1 set for testing');

        //call
        $this->object->updateStudents();
    }
}
