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
use App\Http\Controllers\ExamController;
use App\Http\Requests\ExamRequest;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Exam\IStoredExamStatsRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Laracasts\TestDummy\Factory;
use Mockery\Mock;

use PHPUnit\Framework\Assert as PHPUnit;

class ExportControllerTest extends \TestCase
{
    use WithoutMiddleware;
    public $exam;
public $assignments = [];
    protected $object;
public $num = 3;

    public function setUp()
    {
        parent::setUp();

//        $this->mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $this->exam = factory(Exam::class)->create();
//        $mock = Mockery::mock('\App\Repositories\Exam\IExamRepository');
//        $this->app->instance
        $this->object = new ExportController;

        for($i=0;$i<$this->num;$i++){
            $assignment = \factory(Assignment::class)->create();
            $assignment->exam_id = $this->exam->id;
            $assignment->save();
            array_push($this->assignments, $assignment);
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

    public function testLoadScores()
    {
    }

    public function testLoadItems()
    {

        $this->object->exam = $this->exam;

        $this->object->loadItems();

        PHPUnit::assertEquals(sizeof($this->object->items), $this->num);

    }

}
