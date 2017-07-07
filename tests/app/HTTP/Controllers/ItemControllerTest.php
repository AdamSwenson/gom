<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/1/17
 * Time: 9:39 PM
 */

namespace App\Http\Controllers\Item;

use App\ElementScore;
use App\Exam;
use App\GradingTime;
use App\Http\Controllers\ItemController;
use App\Http\Requests\ItemRequest;
use App\Item;
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
    protected $route = 'items';

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
        //make sure does not retrieve for other users
        $response = $this->get('items');
        $this->assertNotEmpty($response);
    }


    /** @test */
    public function store()
    {
        $item = factory(Item::class)->make();
        $testText = Factory::create()->word;
        $data = [
            'text' => $testText,
            'name' => $testText,
            'maxScore' => Factory::create()->randomNumber(2)
        ];
        //call
        $response = $this->post($this->route . '/' . $item->id, $data);
        //check
        $response->assertStatus(200);
        $this->assertDatabaseHas('items', [
            'text' => $testText,
            'name' => $testText,
            'max_score' => $data['maxScore']
        ]);

    }

    /** @test */
    public function show()
    {
        $item = factory(Item::class)->create();

        $r = ['id' => $item->id];

        //call
        $response = $this->call('GET', $this->route, $r);
        // $this->assertEquals($item, $response);
        $response->assertStatus(200);

    }


//    /** @test */
//    public function show_no_id_set()
//    {
//        $r = [];
//
//        //call
//        $response = $this->call('GET', $this->route, $r);
//        $this->assertEquals(null, $response);
//
//    }

//    /** @test */
//    public function edit()
//    {
//    }

//    /** @test */
//    public function update()
//    {
//        $item = factory(Item::class)->create();
//        $testText = Factory::create()->word;
//        $data = [
//            'id' => $item->id,
//            'text' => $testText,
//            'name' => $testText,
//            'maxScore' => Factory::create()->randomNumber(2)
//        ];
//        //call
//        $response = $this->call('PUT', $this->route . '/' . $item->id, $data);
//        //check
//        $this->assertNotEmpty($response);
//        $response->assertStatus(200);
//        $this->assertDatabaseHas('items', [
//            'id' => $item->id,
//            'text' => $testText,
//            'name' => $testText,
//            'max_score' => $data['maxScore']
//        ]);

//        $this->assertDatabaseHas('items', $data);

//        $loaded = Item::find($item->id);
//        $this->assertNotEmpty($loaded);
//        $this->assertEquals($data['id'], $loaded->id);
//        $this->assertEquals($data['text'], $loaded->text);
//        $this->assertEquals($data['name'], $loaded->name);
//        $this->assertEquals($data['maxScore'], $loaded->max_score);

//        $dao = $this->createMock(IItemRepository::class);
//        $exam = factory(Exam::class)->make();
//        $data = ['order' => [1, 3, 4]];
//        $dao->shouldReceive('handleStoreAndUpdate')->with([$exam, $data])->andReturn($data);
//        //call
//        $response = $this->call('PUT', 'items/' . $exam->id);
//        //check
//        $this->assertNotEmpty($response);
//    }


    /**
     * Remove the specified resource from storage.
     * @test
     */
    public function destroy()
    {
        $item = factory(Item::class)->create();
        $id = $item->id;

        //call
        $response = $this->delete($this->route . '/' . $item->id);

        //check
        //this uses soft deletes so the check is a bit complicated
        $response->assertStatus(200);
        $i = Item::onlyTrashed()->where('id', $id)->get();

        $this->assertNotEmpty($i);
        $this->assertEquals($id, $i->id);
//        $this->assertDatabaseMissing('items', ['id' => $id]);
    }


    /*
 *
 * KEEP THE BELOW FOR THE HYBRID API!!!!!
 *
 *
 *
 */


    /** @test */
    public function updateAll()
    {
        $dao = $this->createMock(IQuestionAssignmentRepository::class);
        $exam = factory(Exam::class)->make();
        $data = ['order' => [1, 3, 4]];
        $dao->shouldReceive('updateAll')->with([$exam, $data])->andReturn($data);
        //call
        $response = $this->call('PATCH', 'items/' . $exam->id);
        //check
        $this->assertNotEmpty($response);
    }

    /** @test */
    public function updateOrder()
    {

        //prep
        $dao = $this->createMock(IQuestionAssignmentRepository::class);
        $exam = factory(Exam::class)->make();
        $data = ['order' => [1, 3, 4]];
        $dao->shouldReceive('updateItemOrder')->with([$exam, $data])->andReturn($data);

        //call
        $response = $this->call('PUT', 'items/' . $exam->id . '/order');

        //check
        $this->assertNotEmpty($response);
    }


}
