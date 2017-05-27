<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/1/17
 * Time: 9:39 PM
 */

namespace App\Http\Controllers;
use App\ElementScore;
use App\Exam;
use App\GradingTime;
use App\Http\Controllers\ItemController;
use App\Http\Requests\ItemRequest;
use App\QuestionAssignment;
use App\QuestionScore;
use App\Repositories\Item\IItemRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Student;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;


class ItemControllerTest extends \TestCase
{
    use WithoutMiddleware;

    protected $object;
    protected $exam;

    public function setUp()
    {
        parent::setUp();
        //    $this->exam = Exam::all()->random();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function testIndex()
    {
        $response = $this->action('GET', 'ItemController@index');
        $this->assertNotEmpty($response);
    }


    /** @test */
    public function handleExam(  )
    {
    }

    /** @test */
    public function handleQuestion( )
    {
    }


    /** @test */
    public function store(){}


    /** @test */
    public function show(){

        //prep
        $dao = $this->createMock(IQuestionAssignmentRepository::class);
        $qas = [1,2,3]; //factory(QuestionAssignment::class)->make();
        $exam = factory(Exam::class)->make();
        $items = [];

        foreach ( $qas as $qAssignment ) {
            $index = $qAssignment;
            $question = $qAssignment;
            $items[$index] = $question;
        }

        $dao->shouldReceive('load_all_for_exam')
            ->with([$exam, ])
            ->andReturn(['exam' => $exam, 'items'=> $items]);

        //call
        $response = $this->call('GET', 'items/' . $exam->id);

    }


    /** @test */
    public function edit( )
    {
    }

    /** @test */
    public function update( )
    {
        $dao = $this->createMock(IItemRepository::class);
        $exam = factory(Exam::class)->make();
        $data = ['order'=> [1, 3, 4]];
        $dao->shouldReceive('handleStoreAndUpdate')->with([$exam, $data])->andReturn($data);
        //call
        $response = $this->call('PUT', 'items/' . $exam->id );
        //check
        $this->assertNotEmpty($response);
    }


    /** @test */
    public function updateAll( )
    {
        $dao = $this->createMock(IQuestionAssignmentRepository::class);
        $exam = factory(Exam::class)->make();
        $data = ['order'=> [1, 3, 4]];
        $dao->shouldReceive('updateAll')->with([$exam, $data])->andReturn($data);
        //call
        $response = $this->call('PATCH', 'items/' . $exam->id );
        //check
        $this->assertNotEmpty($response);
    }

    /** @test */
    public function updateOrder( )
    {

        //prep
        $dao = $this->createMock(IQuestionAssignmentRepository::class);
        $exam = factory(Exam::class)->make();
        $data = ['order'=> [1, 3, 4]];
        $dao->shouldReceive('updateItemOrder')->with([$exam, $data])->andReturn($data);

        //call
        $response = $this->call('PUT', 'items/' . $exam->id . '/order');

        //check
        $this->assertNotEmpty($response);
    }




    /**
     * Remove the specified resource from storage.
     * @test
    */
    public function destroy()
    {
    }



}
