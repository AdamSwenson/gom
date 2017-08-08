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
            'props' => $note->props,
            'priority' => $note->priority
            //associations
//                'exams' => $exams,
//                'items' => $items
        ]);
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
        foreach($notes as $note){
            self::assertNoteInResponse($note, $response);
        }
    }

    /** @test */
    public function store()
    {
        $item = factory(Item::class)->create();

        $note = factory(Note::class)->make();

        $out = ['id' => $note->id,
            'name' => $note->name,
            'text' => $note->text,
            'props' => $note->props,
            'priority' => $note->priority
      ];      //associations
        $route = $this->route . "/item/" . $item->id;
        $response = $this->post($this->route, $out);
        $response->assertStatus(200);

        self::assertNoteInResponse($note, $response);
     }

    public function show()
    {
    }

    public function showForExam()
    {
    }

    public function showForItem()
    {
    }

    public function update()
    {
    }

    /** @test */
    public function destroy()
    {
    }

}
