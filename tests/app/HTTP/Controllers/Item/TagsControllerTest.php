<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/5/17
 * Time: 9:03 AM
 */

namespace App\Http\Controllers\Item;

use App\Exam;
use App\Item;
use App\Kumi;
use App\Models\NewGom\Tag;
use App\Student;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert as PHPUnit;
use TestCase;

class TagsControllerTest extends TestCase
{

    use WithoutMiddleware;

    public $student;
    public $item;
    public $numTags;
    protected $tag;
    protected $exam;
    protected $route = 'dev/tags';

    public function setUp()
    {
        parent::setUp();
        $this->numTags = 4; //$this->faker->randomDigit();

        $this->exam = factory(Exam::class)->create();
        $this->exam->save();
        $this->tag = factory(Tag::class)->create();
        $this->item = \factory(Item::class)->create();
        $this->student = \factory(Student::class)->create();
    }


    public function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public static function assertTagInResponse( Tag $tag, $response )
    {
        $response->assertJsonFragment([
            'id' => $tag->id,
            'name' => $tag->name,
            'text' => $tag->text,
            'props' => $tag->props,
            //associations
//                'exams' => $exams,
//                'items' => $items
        ]);
    }


    public static function makeNewTagRequestData()
    {
        //make but don't create
        //that way we have valid fields but nothing in the db
        $tag = factory(Tag::class)->make();
        return [
            'name' => $tag->name,
            'text' => $tag->text,
            'props' => $tag->props,
        ];
    }

    public static function tagObjects( $tags, $objects )
    {
        foreach ( $objects as $obj ) {
            foreach ( $tags as $tag ) {
                $obj->tags()->attach($tag->id);
                $obj->save();
            }
        }
    }


    /** @test */
    public function index()
    {
        $numTags = 2;
        $numTaggedObjects = 2;
        $user = \factory(User::class)->create();
        Auth::login($user);
        $tags = \factory(Tag::class, $numTags)->create();
        $exams = \factory(Exam::class, $numTaggedObjects)->create();
        $items = \factory(Item::class, $numTaggedObjects)->create();

        foreach ( $exams->concat($items) as $obj ) {
            foreach ( $tags as $tag )
                $obj->tags()->attach($tag);
        }
        //call
        $response = $this->get($this->route);

        //check
        $response->assertStatus(200);

        foreach ( $tags as $tag ) {
            $response->assertJsonFragment([
                'id' => $tag->id,
                'name' => $tag->name,
                'text' => $tag->text,
                'props' => $tag->props]);

//todo test that eager loads associations
//            foreach ( $exams as $exam ) {
//                $response->assertJsonFragment([
//                    //associations
//                    'pivot' => ['exam_id' => $exam->id]
//                ]);
//            }
        }
    }

    /** @test */
    public function store()
    {
        $tag = self::makeNewTagRequestData();

        //call
        $response = $this->post($this->route, $tag);

        //check
        $response->assertStatus(200);
        $response->assertJsonFragment($tag); //should return the object

//        $this->assertDatabaseHas('tags', [
//            'name' => $tag['name'],
//            'text' => $tag['text'],
//            'props' => $tag['props']
//        ]);


    }


    /** @test */
    public function associateTagWithExam()
    {
//        $exam = \factory(Exam::class)->create();
//        $tag = factory(Tag::class)->create();
        $route = $this->route . "/exam/{$this->exam->id}/tag/{$this->tag->id}";

        $response = $this->post($route);

        //check
        $response->assertStatus(200);

        $exam = Exam::find($this->exam->id);

        $r = $exam->tags()->first();

        $this->assertNotEmpty($r);
        $this->assertEquals($this->tag->id, $r->id);
//        $this->assertDatabaseHas('exam_tag', [
//            'exam_id' => $this->exam->id,
//            'tag_id' => $this->tag->id
//        ]);
    }

    /** @test */
    public function disassociateTagFromExam()
    {
        $this->exam->tags()->attach($this->tag);

        $route = $this->route . "/exam/{$this->exam->id}/tag/{$this->tag->id}";

        $response = $this->delete($route);

        //check
        $response->assertStatus(200);

        $this->assertDatabaseMissing('exam_tag', [
            'exam_id' => $this->exam->id,
            'tag_id' => $this->tag->id
        ]);

    }


    /** @test */
    public function associateTagWithItem()
    {
        $user = \factory(User::class)->create();
        Auth::login($user);
        $item = \factory(Item::class)->create();
        $tag = \factory(Tag::class)->create();
        $item->save();
        $tag->save();
        $route = $this->route . "/item/{$item->id}/tag/{$tag->id}";

        $response = $this->actingAs($user)->post($route);

        //check
        $response->assertStatus(200);

//       $r = DB::select("select * from item_tag where item_id = {$this->item->id} and tag_id = {$this->tag->id}");
//        $this->assertNotEmpty($r);
//        $this->assertDatabaseHas('item_tag', [
//            'item_id' => $item->id,
//            'tag_id' => $tag->id
//        ]);

    }


    /** @test */
    public function disassociateTagFromItem()
    {
        $this->item->tags()->attach($this->tag);

        $route = $this->route . "/item/{$this->item->id}/tag/{$this->tag->id}";

        $response = $this->delete($route);

        //check
        $response->assertStatus(200);

//        $this->assertDatabaseMissing('item_tag', [
//            'item_id' => $this->item->id,
//            'tag_id' => $this->tag->id
//        ]);

    }

    /** @test */
    public function associateTagWithStudent()
    {
        $route = $this->route . "/student/{$this->student->id}/tag/{$this->tag->id}";

        $response = $this->post($route);

        //check
        $response->assertStatus(200);

//        $this->assertDatabaseHas('student_tag', [
//            'student_id' => $this->student->id,
//            'tag_id' => $this->tag->id
//        ]);

    }


    /** @test */
    public function disassociateTagFromStudent()
    {
        $this->student->tags()->attach($this->tag->id);

        $route = $this->route . "/student/{$this->student->id}/tag/{$this->tag->id}";

        $response = $this->delete($route);

        //check
        $response->assertStatus(200);

        $this->assertDatabaseMissing('student_tag', [
            'student_id' => $this->student->id,
            'tag_id' => $this->tag->id
        ]);


    }


    /** @test */
    public function show()
    {
        $route = $this->route . '/' . $this->tag->id;

        $response = $this->get($route);

        //check
        $response->assertStatus(200);
        self::assertTagInResponse($this->tag, $response);
    }

    /** @test */
    public function showForExam()
    {
        $route = $this->route . '/exam/' . $this->exam->id;
        $tags = \factory(Tag::class, $this->numTags)->create();
        self::tagObjects($tags, [$this->exam]);

        //call
        $response = $this->get($route);

        //check
        $response->assertStatus(200);
        foreach ( $tags as $tag ) {
            self::assertTagInResponse($tag, $response);
        }

    }

    /** @test */
    public function showForItem()
    {
        $route = $this->route . '/item/' . $this->item->id;
        $tags = \factory(Tag::class, $this->numTags)->create();
        self::tagObjects($tags, [$this->item]);

        //call
        $response = $this->get($route);

        //check
        $response->assertStatus(200);
        foreach ( $tags as $tag ) {
            self::assertTagInResponse($tag, $response);
        }

    }

    /** @test */
    public function showForStudent()
    {
        $route = $this->route . '/student/' . $this->student->id;
        $tags = \factory(Tag::class, $this->numTags)->create();
        self::tagObjects($tags, [$this->student]);

        //call
        $response = $this->get($route);

        //check
        $response->assertStatus(200);
        foreach ( $tags as $tag ) {
            self::assertTagInResponse($tag, $response);
        }

    }

    /** @test */
    public function update()
    {
        $tag = factory(Tag::class)->create();
        $newData = self::makeNewtagRequestData();

        //call
        $response = $this->put($this->route . '/' . $tag->id, $newData);

        //check
        $response->assertStatus(200);

        $o = Tag::find($tag->id);
        PHPUnit::assertTrue(isset($o));
        PHPUnit::assertEquals($tag->name, $o->name);
        PHPUnit::assertEquals($tag->text, $o->text);
        PHPUnit::assertEquals($tag->props, $o->props);

//        $this->assertDatabaseHas('tags', $o->toArray());
//            [
//                'id' => $tag->id,
//                'name' => $tag->name,
//                'text' => $tag->text,
//                'props' => $tag->props,
//            ]);
    }

    /** @test */
    public function destroy()
    {
        $tag = factory(Tag::class)->create();
        $this->assertDatabaseHas('tags', $tag->toArray());
//            [
//                'id' => $tag->id,
//                'name' => $tag->name,
//                'text' => $tag->text,
//                'props' => $tag->props,
//            ]);

        //call
        $response = $this->delete($this->route . '/' . $tag->id);

        //check
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tags',
            [
                'id' => $tag->id,
                'name' => $tag->name,
                'text' => $tag->text,
                'props' => $tag->props,
            ]);

    }
}