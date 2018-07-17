<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/18
 * Time: 3:02 PM
 */

namespace App\Http\Controllers\Export;


use App\Assignment;
use App\Exam;
use App\GradeAssignment;
use App\Http\Controllers\ExamController;
use App\Http\Requests\ExamRequest;
use App\Models\NewGom\ItemScore;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Exam\IStoredExamStatsRepository;
use App\Repositories\Grade\IStudentGradeRepository;
use App\Student;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Laracasts\TestDummy\Factory;
use Mockery;
use Mockery\Mock;

use PHPUnit\Framework\Assert as PHPUnit;

class ExportControllerTest extends \TestCase
{
    use WithoutMiddleware;
    public $exam;
    public $assignments = [];
    public $expectedItemIds = [];
    public $students = [];
    public $scores = [];

    protected $object;
    public $num = 3;
    public $numStudents = 4;

    public function setUp()
    {
        parent::setUp();

//        $this->mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $this->exam = factory(Exam::class)->create();
        $this->students = factory(Student::class, $this->numStudents)->create();

//        $this->app->instance
        $this->object = new ExportController;
        $this->object->exam = $this->exam;

        for ( $i = 0; $i < $this->num; $i++ ) {
            $assignment = \factory(Assignment::class)->create();
            $assignment->exam_id = $this->exam->id;
            $assignment->save();
            array_push($this->assignments, $assignment);
            array_push($this->expectedItemIds, $assignment->item_id);

            foreach ( $this->students as $student ) {
                $score = new ItemScore();
//                $score = \factory(ItemScore::class)->make(); //not using create so won't freak out on missing foreign keys
                $score->exam()->associate($this->exam);
                $score->item()->associate($assignment->item);
                $score->student()->associate($student->id);
                //now that everyone is associated, we can save the score
                $score->save();
                $this->scores[] = $score;
            }
        }
    }


    public function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }


    public function testExportExamScores()
    {

    }

    public function testWrite_and_return_csv_file()
    {

    }

    public function testLoadItems()
    {
        $this->object->loadItems();

        PHPUnit::assertEquals(sizeof($this->object->items), $this->num);
        foreach ( $this->object->items as $item ) {
            PHPUnit::assertContains($item->id, $this->expectedItemIds, "Items have correct ids");
            PHPUnit::assertContains($item->name, $this->object->headers, "item name added to headers list");
        }

    }

    public function testLoadScores()
    {
        $expectedTotal = 44;
        $ga = new GradeAssignment();
        $ga->display_value = 'F-';
        $ga->calc_value = 33;

        $mock = Mockery::mock(IStudentGradeRepository::class);
        $mock->shouldReceive('calculateTotalScoreForStudent')->andReturn($expectedTotal);
        $mock->shouldReceive('getStudentGrade')->andReturn($ga);

        $this->object->loadScores();

        //check
        PHPUnit::assertEquals(sizeof($this->object->records), $this->numStudents);
    }

}
