<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/21/17
 * Time: 8:30 PM
 */

namespace App\Http\Controllers;


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
        $exam = factory(Exam::class)->make();
        $data = ['order' => [2,3]];

        $dao = $this->createMock(IAssignmentRepository::class);
        $dao->shouldReceive('processIncoming')
            ->with([$exam, $data])
            ->andReturn(true);

        //call
        $response = $this->call('POST', 'items/' . $exam->id . '/order', $data);
        $this->assertNotNull($response);

    }


}
