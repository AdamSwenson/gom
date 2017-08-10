<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/21/17
 * Time: 8:30 PM
 */

namespace App\Http\Controllers\Item;


use App\Assignment;
use App\Exam;
use App\Http\Requests\ItemRequest;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssignmentControllerTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function store(){
        //prep
        $exam = factory(Exam::class)->create();
        $data = ['order' => [2,3]];

$route = "dev/setup/{$exam->id}/order";

        $dao = $this->createMock(IAssignmentRepository::class);
        $dao->shouldReceive('processIncoming')
            ->with([$exam, $data])
            ->andReturn(true);

        //call
        $response = $this->post($route, $data);
        $this->assertNotNull($response);
$response->assertStatus(200);
    }


}
