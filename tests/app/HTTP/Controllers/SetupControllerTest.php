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
    }


    /** @test */
    public function show()
    {
        //prep
        $dao = $this->createMock(IAssignmentRepository::class);

        $exam = factory(Exam::class)->make();

        $dao->shouldReceive('getItemOrderForClient')
            ->with([$exam])
            ->andReturn(['itemObjects' => [], 'itemOrder' => []]);

        //call
        $response = $this->call('GET', $this->route . '/' . $exam->id);
$this->assertNotEmpty($response);
    }


}
