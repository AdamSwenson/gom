<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/10/17
 * Time: 1:30 PM
 */

namespace App\Http\Controllers\Item;


use App\Exam;
use App\Kumi;
use App\Student;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RosterControllerTest extends \TestCase
{

    use WithoutMiddleware;

    protected $object;
    protected $exam;
    protected $route = 'dev/roster';

    public function setUp()
    {
        parent::setUp();
    }


    public function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function associateStudent()
    {
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();
        $kumi = factory(Kumi::class)->create();
        $kumi->exams()->attach($exam->id);
        $kumi->save();
        $studentId = $student->id;
        $kumiId = $kumi->id;

        $route = "dev/roster/{$studentId}/assoc/{$kumiId}";

        //call
        $response = $this->post($route);

        //check
        $response->assertStatus(200);

        $this->assertDatabaseHas('kumi_student',
            ['kumi_id' => $kumiId, 'student_id' => $studentId]
        );

//        $k = Kumi::find($kumiId);
//        //$inDB = $k->students()->where('student_id', $student->id)->first();
////        dd($inDB);
////        $this->assertEquals($inDB->id, $student->id);
//        $this->assertEquals($k->id, $kumiId);
//        $s = $k->students;
//        $this->assertTrue(sizeof($s) > 0);

    }


    /** @test */
    public function disassociateStudent()
    {
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();
        $kumi = factory(Kumi::class)->create();
        $kumi->exams()->attach($exam->id);
        $student->kumis()->attach($kumi->id);
        $student->save();
        $studentId = $student->id;
        $kumiId = $kumi->id;
        $this->assertDatabaseHas('kumi_student',
            ['kumi_id' => $kumiId, 'student_id' => $studentId]
        );

        $route = "dev/roster/{$studentId}/diss/{$kumiId}";
echo($route);
        //call
        $response = $this->post($route);

        //check
        $response->assertStatus(200);
        $this->assertDatabaseMissing('kumi_student',
            ['kumi_id' => $kumi->id, 'student_id' => $student->id]
        );

    }


    /** @test */
    public function getStudentsForExam()
    {
        $exam = factory(Exam::class)->create();
        $students = factory(Student::class, 5)->create();
        $kumi = factory(Kumi::class)->create();
        $kumi->exams()->attach($exam);
        foreach ( $students as $student ) {
            $student->kumis()->attach($kumi);
        }
        $this->assertEquals(5, sizeof($kumi->students));

        $route = "dev/roster/{$exam->id}";

        //call
        $response = $this->get($route);

        //check
        $response->assertStatus(200);

        foreach ( $students as $student ) {
            $response->assertJsonFragment($student->toArray());
        };
    }


    /** @test */
    public function anonymizeStudents()
    {
//        $exam = factory(Exam::class)->create();

    }

}
