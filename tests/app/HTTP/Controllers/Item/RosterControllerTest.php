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
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class RosterControllerTest extends \TestCase
{

    use WithoutMiddleware;

    public $student;
    protected $object;
    protected $exam;
    protected $route = 'dev/roster';

    public function setUp()
    {
        parent::setUp();
        $user = factory(User::class)->create();
        Auth::login($user);
        $this->exam = factory(Exam::class)->create();
        $this->student = factory(Student::class)->create();
        $this->kumi = factory(Kumi::class)->create();

    }


    public function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function associateStudent()
    {
        $this->kumi->exams()->attach($this->exam->id);
        $this->kumi->save();
        $studentId = $this->student->id;
        $kumiId = $this->kumi->id;

        $route = "dev/roster/{$studentId}/assoc/{$kumiId}";

        //call
        $response = $this->post($route);

        //check
        $response->assertStatus(200);

//        $e = $this->kumi->students()->first();

//        $this->assertNotEmpty($e);
//        $this->assertEquals($studentId, $e->id);

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
        $this->kumi->exams()->attach($this->exam->id);
        $this->student->kumis()->attach($this->kumi->id);
        $this->student->save();
        $studentId = $this->student->id;
        $kumiId = $this->kumi->id;
        $this->assertDatabaseHas('kumi_student',
            ['kumi_id' => $kumiId, 'student_id' => $studentId]
        );

        $route = "dev/roster/{$studentId}/diss/{$kumiId}";

        //call
        $response = $this->post($route);

        //check
        $response->assertStatus(200);
        $this->assertDatabaseMissing('kumi_student',
            ['kumi_id' => $this->kumi->id, 'student_id' => $this->student->id]
        );

    }


    /** @test */
    public function getStudentsForExam()
    {
        $students = factory(Student::class, 5)->create();
        $this->kumi->exams()->attach($this->exam);
        foreach ( $students as $student ) {
            $student->kumis()->attach($this->kumi);
        }
        $this->assertEquals(5, sizeof($this->kumi->students));

        $route = "dev/roster/exam/{$this->exam->id}";

        //call
        $response = $this->get($route);

        //check
        $response->assertStatus(200);

        foreach ( $students as $student ) {
            $expect = [
                'firstName' => $student->first_name,
                'lastName' => $student->last_name,
               // 'studentIdentifier' => `{$student->student_identifier}`,
                'id' => $student->id,
                'email' => $student->email];

            $response->assertJsonFragment($expect);
        };
    }


    /** @test */
    public function anonymizeStudents()
    {
//        $exam = factory(Exam::class)->create();

    }

}
