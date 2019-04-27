<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/17
 * Time: 9:45 AM
 */

namespace App\Http\Controllers\Item;


use App\Exam;
use App\Item;
use App\Models\NewGom\ItemScore;
use App\Student;

class ItemScoreControllerTest extends \TestCase
{


    static $baseRoute = 'dev/scores';
    public $students;
    public $numberItems;
    public $numberStudents;
    public $items;
    public $exam;
    public $numberExams;


    protected $object;

    /**
     *
     */
    public function setUp()
    {

        parent::setUp();

        $this->numberExams = 1;
        $this->numberItems = 2;
        $this->numberStudents = 5;
        $this->exam = factory(Exam::class)->create();
        $this->items = factory(Item::class, $this->numberItems)->create();
        $this->students = factory(Student::class, $this->numberStudents)->create();

    }


//    public function loadIdentifiers( ItemScoreRequest $request )
//    {
//        $this->exam = Exam::find($request->examId);
//        $this->item = Item::find($request->itemId);
//        $this->student = Student($request->studentId);
////todo add error handling here so this kills it if there's a missing value
//    }


    /** @test */
    public function saveScoreWhereBrandNew()
    {
        $item = factory(Item::class)->create();
        $student = $this->students[0];

        $payload = ['examId' => $this->exam->id,
            'itemId' => $item->id,
            'studentId' => $student->id,
            'commentText' => 'taco',
            'score' => $this->faker->randomNumber(4),
            '_token' => csrf_token()
        ];


        $route = self::$baseRoute . '/' . $this->exam->id . '/' . $item->id . '/' . $student->id;
        $response = $this->json('POST', $route, $payload);

        //check
        $this->assertNotEmpty($response);
        $response->assertStatus(200);

        $score = ItemScore::where('exam_id', $this->exam->id)
            ->where('item_id', $item->id)
            ->where('student_id', $student->id)
            ->first();

        $this->assertEquals($payload['commentText'], $score->comment_text);
        $this->assertEquals($payload['score'], $score->score);
    }

    /** @test */
    public function saveScoreWhereExisting()
    {
        //prep
        $item = factory(Item::class)->create();
        $student = $this->students[0];
        $score = factory(ItemScore::class)->make(); //not using create so won't freak out on missing foreign keys
        $score->exam()->associate($this->exam);
        $score->item()->associate($item->id);
        $score->student()->associate($student->id);
        //now that everyone is associated, we can save the score
        $score->save();

        $payload = ['examId' => $this->exam->id,
            'itemId' => $item->id,
            'studentId' => $student->id,
            'commentText' => $this->faker->word(),
            'score' => $this->faker->randomNumber(4),
            '_token' => csrf_token()
        ];


        $route = self::$baseRoute . '/' . $this->exam->id . '/' . $item->id . '/' . $student->id;
        $response = $this->json('POST', $route, $payload);

        //check
        $this->assertNotEmpty($response);
        $response->assertStatus(200);

        $score = ItemScore::where('exam_id', $this->exam->id)
            ->where('item_id', $item->id)
            ->where('student_id', $student->id)
            ->first();

        $this->assertEquals($payload['commentText'], $score->comment_text);
        $this->assertEquals($payload['score'], $score->score);
    }

    /** @test */
    public function resetComment()
    {
        $item = factory(Item::class)->create();
        $student = $this->students[0];
        $score = factory(ItemScore::class)->make(); //not using create so won't freak out on missing foreign keys
        $score->exam()->associate($this->exam);
        $score->item()->associate($item->id);
        $score->student()->associate($student->id);
        //now that everyone is associated, we can save the score
        $score->save();

        //call
        $route = self::$baseRoute . '/' . $this->exam->id . '/' . $item->id . '/' . $student->id . '/comment';
        $response = $this->json('DELETE', $route);

        //check
//        $this->assertNotEmpty($response);
        $response->assertStatus(200);

        $s2 = ItemScore::where('exam_id', $this->exam->id)
            ->where('item_id', $item->id)
            ->where('student_id', $student->id)
            ->first();

        $this->assertNull($s2->comment_text);
        //check that score was untouched
        $this->assertEquals($score->score, $s2->score);

    }

    /** @test */
    public function resetScore()
    {
        $item = factory(Item::class)->create();
        $student = $this->students[0];
        $score = factory(ItemScore::class)->make(); //not using create so won't freak out on missing foreign keys
        $origText = $score->comment_text;
        $score->exam()->associate($this->exam);
        $score->item()->associate($item->id);
        $score->student()->associate($student->id);
        //now that everyone is associated, we can save the score
        $score->save();

        //call
        $route = self::$baseRoute . '/' . $this->exam->id . '/' . $item->id . '/' . $student->id;
        $response = $this->json('DELETE', $route);

        //check
//        $this->assertNotEmpty($response);
        $response->assertStatus(200);

        $s2 = ItemScore::where('exam_id', $this->exam->id)
            ->where('item_id', $item->id)
            ->where('student_id', $student->id)
            ->first();

        $this->assertNull($s2->score);
        //check that comment text was untouched
        $this->assertEquals($origText, $s2->comment_text);

    }

    /** @test */
    public function itemScores()
    {
        $expectedScores = [];
        $item = factory(Item::class)->create();
        foreach ( $this->students as $student ) {
            $score = factory(ItemScore::class)->make(); //not using create so won't freak out on missing foreign keys
            $score->exam()->associate($this->exam);
            $score->item()->associate($item->id);
            $score->student()->associate($student->id);
            //now that everyone is associated, we can save the score
            $score->save();
            $expectedScores[] = $score;
        }

        $route = self::$baseRoute . '/item/' . $item->id;
        $response = $this->get($route);

        //check
        $this->assertNotEmpty($response);
        $response->assertStatus(200);

        foreach ( $expectedScores as $score ) {
            $response->assertJsonFragment(['comment_text' => $score->comment_text,
                'item_id' => $score->item_id,
                'exam_id' => $score->exam_id,
                'student_id' => $score->student_id,
                'score' => $score->score,
                'id' => $score->id
            ]);
//            $response->assertJsonFragment($score->toArray());
        }

    }

    /** @test */
    public function examScores()
    {
        //todo This should probably have multiple items and multiple kumi as cases

        $expectedScores = [];
        $item = factory(Item::class)->create();
        foreach ( $this->students as $student ) {
            $score = factory(ItemScore::class)->make(); //not using create so won't freak out on missing foreign keys
            $score->exam()->associate($this->exam);
            $score->item()->associate($item);
            $score->student()->associate($student);
            //now that everyone is associated, we can save the score
            $score->save();
            $expectedScores[] = $score;
        }

        $route = self::$baseRoute . '/exam/' . $this->exam->id;
        $response = $this->get($route);

        //check
        $this->assertNotEmpty($response);
        $response->assertStatus(200);

        foreach ( $expectedScores as $score ) {
            $response->assertJsonFragment(['comment_text' => $score->comment_text,
                'item_id' => $score->item_id,
                'exam_id' => $score->exam_id,
                'student_id' => $score->student_id,
                'score' => $score->score,
                'id' => $score->id
            ]);
//            $response->assertJsonFragment($score->toArray());
        }


//        return ItemScore::where('exam_id', $exam1->id)->get();
    }

    /** @test */
    public function studentScores()
    {
        //todo This should probably have multiple items, exams, and multiple kumi as cases

        $expectedScores = [];
        $items = factory(Item::class, $this->numberItems)->create();
        $student = factory(Student::class)->create();
        foreach ( $items as $item ) {
            $score = factory(ItemScore::class)->make(); //not using create so won't freak out on missing foreign keys
            $score->exam()->associate($this->exam);
            $score->item()->associate($item);
            $score->student()->associate($student);
            //now that everyone is associated, we can save the score
            $score->save();
            $expectedScores[] = $score;
        }

        $route = self::$baseRoute . '/student/' . $student->id;
        $response = $this->get($route);

        //check
        $this->assertNotEmpty($response);
        $response->assertStatus(200);

        foreach ( $expectedScores as $score ) {
            $response->assertJsonFragment(['comment_text' => $score->comment_text,
                'item_id' => $score->item_id,
                'exam_id' => $score->exam_id,
                'student_id' => $score->student_id,
                'score' => $score->score,
                'id' => $score->id
            ]);
        }
    }


}
