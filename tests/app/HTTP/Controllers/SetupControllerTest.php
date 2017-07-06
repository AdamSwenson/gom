<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/17
 * Time: 3:55 PM
 */

namespace App\Http\Controllers;


use App\Exam;
use App\Repositories\Question\IQuestionAssignmentRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;


/**
 * Class SetupControllerTest
 * @package App\Http\Controllers
 * @group controllers
 * @group newsetup
 */
class SetupControllerTest extends \TestCase
{
    use WithoutMiddleware;

    protected $object;
    protected $exam;

    protected $route = 'setup';

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
        $response = $this->get($this->route);
        $this->assertNotEmpty($response);
        $response->assertStatus(302);
    }


    /** @test */
    public function show()
    {
        //prep
        $dao = $this->createMock(IAssignmentRepository::class);

        $exam = factory(Exam::class)->make();

        $dao->shouldReceive('getItemOrderForClient')
            ->with([$exam])
            ->andReturn(['itemObjects' => ['a'], 'itemOrder' => ['b']]);

        //call
        $response = $this->get($this->route . '/' . $exam->id);
        $this->assertNotEmpty($response);

        $response->assertStatus(302);

        $expected = [
            'examObjectJsonName' => SetupController::EXAM_JSON_NAME,
            'itemObjectJsonName' => SetupController::ITEM_OBJECT_JSON_NAME,
            'itemOrderJsonName' => SetupController::ITEM_ORDER_JSON_NAME,
            'exam' => $exam,
            'itemObjects' => ['a'],
            'itemOrder' => ['b']
        ];

//        $response->assertViewHasAll($expected);

    }


}
