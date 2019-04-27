<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/17
 * Time: 9:45 AM
 */

namespace App\Http\Controllers\Item;


use App\Exam;
use App\Http\Requests\ItemScoreRequest;
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


    /** @test*/
    public function store( )
    {
//        $this->loadIdentifiers($request);
//        //if no exception, we assume everything is set
//        $score = ItemScore::where('exam_id', $this->exam->id)
//            ->where('student_id', $this->student->id)
//            ->where('item_id', $this->item->id)
//            ->first();
//
//        if ( !isset($score) ) {
//            //doing this explicitly since
//            //there's some problem when try the
//            //eloquent way
//            $score = new ItemScore();
//            $score->exam_id = $this->exam->id;
//            $score->item_id = $this->item->id;
//            $score->student_id = $this->student->id;
//        }
//
//        //Now, whether old or new, we set the data
//        //properties
//        $score->score = $request->input('score');
//        $score->comment_text = $request->input('commentText');
//        //and finally save
//        $score->save();
//
//        return $score;

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

        foreach($expectedScores as $score){
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

        foreach($expectedScores as $score){
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

        foreach($expectedScores as $score){
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
