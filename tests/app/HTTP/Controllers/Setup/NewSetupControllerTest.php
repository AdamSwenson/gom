<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/17
 * Time: 3:55 PM
 */

namespace App\Http\Controllers\Setup;


use App\Exam;
use App\Repositories\Assignment\IAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;


/**
 * Class SetupControllerTest
 * @package App\Http\Controllers
 * @group controllers
 * @group newsetup
 */
class NewSetupControllerTest extends \TestCase
{
    use WithoutMiddleware;

    protected $object;
    protected $exam;

    protected $route = 'dev/setup';

    public function setUp()
    {
        parent::setUp();
        //    $this->exam1 = Exam::all()->random();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function testIndex()
    {
        $response = $this->get($this->route);
        $this->assertNotEmpty($response);
        $response->assertStatus(302);
    }


    /** @test */
    public function show()
    {
        //prep
        $dao = $this->createMock(IAssignmentRepository::class);
        $exam = factory(Exam::class)->create();

        $route = $this->route . '/' . $exam->id;
//        $dao->shouldReceive('getItemOrderForClient')->once()
//            ->with([$exam])
//            ->andReturn(['itemObjects' => ['a'], 'itemOrder' => ['b']]);

        //call
        $response = $this->get($route);
        $this->assertNotEmpty($response);
        $response->assertStatus(200);

//        $response->assertViewHas([
//            'examObjectJsonName' => NewSetupController::EXAM_JSON_NAME,
//            'itemObjectJsonName' => NewSetupController::ITEM_OBJECT_JSON_NAME,
//            'itemOrderJsonName' => NewSetupController::ITEM_ORDER_JSON_NAME
//        ]);

        //make sure keys are available
//        $response->assertViewHas('examObjectJsonName', NewSetupController::EXAM_JSON_NAME);
//        $response->assertViewHas('itemObjectJsonName', NewSetupController::ITEM_OBJECT_JSON_NAME);
//        $response->assertViewHas('itemOrderJsonName', NewSetupController::ITEM_ORDER_JSON_NAME);
        // $response->assertViewHas('exam1', $exam1);
//        $response->assertViewHas('itemObjects'); //, ['a']);
//        $response->assertViewHas('itemOrder'); //, ['b']);

        //        $expected = ,
//            'exam1' => $exam1,
//            'itemObjects' => ['a'],
//            'itemOrder' => ['b']
//        ];

    }

    /** @test */
    public function findEmptyExam(){
        $e = Exam::all();
    var_dump(sizeof($e));
    }


}
