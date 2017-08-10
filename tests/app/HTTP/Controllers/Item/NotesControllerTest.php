<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/5/17
 * Time: 10:18 AM
 */

namespace App\Http\Controllers\Item;

use App\Exam;
use App\Item;
use App\Kumi;
use App\Models\NewGom\Note;
use App\Models\NewGom\Tag;
use App\Student;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert as PHPUnit;

class NotesControllerTest extends \TestCase
{
    use WithoutMiddleware;

    protected $object;
    protected $route = 'dev/notes';

    public function setUp()
    {
        parent::setUp();
    }

    public static function assertNoteInResponse( Note $note, $response )
    {
        $response->assertJsonFragment([
            'id' => $note->id,
            'name' => $note->name,
            'text' => $note->text,
//            'props' => $note->props,
            'priority' => $note->priority
            //associations
//                'exams' => $exams,
//                'items' => $items
        ]);
    }

    public static function makeNoteRequestData()
    {
        $note = factory(Note::class)->make();
        return [
            'name' => $note->name,
            'text' => $note->text,
            'props' => $note->props,
            'priority' => $note->priority
        ];
    }

    /** @test */
    public function index()
    {
        $user = \factory(User::class)->create();
        Auth::login($user);
        $numNotes = 5;
        $notes = factory(Note::class, $numNotes)->create();

        //call
        $response = $this->get($this->route);

        //check
        $response->assertStatus(200);
        foreach ( $notes as $note ) {
            self::assertNoteInResponse($note, $response);
        }
    }

    /** @test */
    public function store()
    {
        $item = factory(Item::class)->create();
        $data = self::makeNoteRequestData();
        $route = $this->route . "/item/" . $item->id;

        //call
        $response = $this->post($route, $data);

        //check
        $response->assertStatus(200);
//        $this->assertDatabaseHas('notes', $data);
        $n = Note::where('name', $data['name'])
            ->where('text', $data['text'])
//            ->where('props', $data['props'])
            ->where('priority', $data['priority'])
            ->first();

        PHPUnit::assertTrue(isset($n));
        self::assertNoteInResponse($n, $response);
    }

    /** @test */
    public function show()
    {
        $note = factory(Note::class)->create();

        $route = $this->route . "/" . $note->id;

        //call
        $response = $this->get($route);

        //check
        $response->assertStatus(200);
        self::assertNoteInResponse($note, $response);
    }

    /** @test */
    public function showForExam()
    {
        $numNotes = 5;
        $exam = factory(Exam::class)->create();
        $notes = \factory(Note::class, $numNotes )->create();
        foreach($notes as $note){
            $exam->notes()->attach($note->id);
            $exam->save();
        }
        $route = $this->route . '/exam/' . $exam->id;
        
        //call
        $response = $this->get($route);
        
        //check
        $response->assertStatus(200);
        foreach($notes as $note){
            self::assertNoteInResponse($note, $response);
        }
        
    }

    /** @test */
    public function showForItem()
    {

        $numNotes = 5;
        $item = factory(Item::class)->create();
        $notes = \factory(Note::class, $numNotes )->create();
        foreach($notes as $note){
            $item->notes()->attach($note->id);
            $item->save();
        }
        $route = $this->route . '/item/' . $item->id;

        //call
        $response = $this->get($route);

        //check
        $response->assertStatus(200);
        foreach($notes as $note){
            var_dump($note);
            $response->assertJsonFragment(['id' => $note->id]);
//            self::assertNoteInResponse($note, $response);
        }
    }

    /** @test */
    public function update()
    {
        $note = factory(Note::class)->create();
        $data = self::makeNoteRequestData();

        //call
        $response = $this->put($this->route . '/' . $note->id, $data);

        //check
        $response->assertStatus(200);

        $o = Note::find($note->id);
        PHPUnit::assertTrue(isset($o));
        PHPUnit::assertEquals($note->name, $o->name);
        PHPUnit::assertEquals($note->text, $o->text);
        PHPUnit::assertEquals($note->props, $o->props);

    }

    /** @test */
    public function destroy()
    {
        $note = factory(Note::class)->create();

        //call
        $response = $this->delete($this->route . '/' . $note->id);

        //check
        $response->assertStatus(200);
        $this->assertDatabaseMissing('notes', $note->toArray());
    }

}
