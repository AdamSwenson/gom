<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/10/17
 * Time: 11:38 AM
 */

namespace App\Http\Controllers\Item;

use App\Student;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class StudentResourceControllerTest extends \TestCase
{

    use WithoutMiddleware;

    protected $object;
    protected $exam;
    protected $route = 'dev/students';

    public function setUp()
    {
        parent::setUp();
    }


    public function tearDown()
    {
        \Mockery::close();
    }

    public static function assertStudentInResponse( Student $student, $response )
    {
        $test = [
            'id' => $student->id,
            'lastName' => $student->lastName,
            'firstName' => $student->firstName,
            'studentIdentifier' => "{$student->studentIdentifier}",
            'email' => $student->email
        ];
        $response->assertJsonFragment($test);
    }

    public static function makeNewStudentRequestData()
    {
        //make but don't create
        //that way we have valid fields but nothing in the db
        $student = factory(Student::class)->make();
        return [
            'lastName' => $student->lastName,
            'firstName' => $student->firstName,
            'studentIdentifier' => $student->studentIdentifier,
            'email' => $student->email
        ];
    }


    /** @test */
    public function index()
    {
        //This will be messed up if there are other students around
        //So we will do this with a new user
        $user = $user = factory(User::class)->create();
        Auth::login($user);

        $numStudents = 5;
        $students = factory(Student::class, $numStudents)->create();

        //call
        $response = $this->get($this->route);

        //check
        $response->assertStatus(200);

        foreach ( $students as $student ) {
//            $response->assertJsonFragment($student->toArray());
            $response->assertJsonFragment([
                'id' => $student->id,
                'lastName' => $student->lastName,
                'firstName' => $student->firstName,
                'studentIdentifier' => "{$student->studentIdentifier}",
                'email' => $student->email
            ]);
        }
    }


    /** @test */
    public function store()
    {
        $student = self::makeNewStudentRequestData();

        //call
        $response = $this->post($this->route, $student);

        //check
        $response->assertStatus(200);
        $response->assertJsonFragment($student); //should return the object
        $this->assertDatabaseHas('students', [
            'last_name' => $student['lastName'],
            'first_name' => $student['firstName'],
            'student_identifier' => $student['studentIdentifier'],
            'email' => $student['email']
        ]);

    }

    /** @test */
    public function show()
    {
        $student = factory(Student::class)->create();
        $student->save();
        //call
        $response = $this->get($this->route . '/' . $student->id);

        //check
        $response->assertStatus(200);
        self::assertStudentInResponse($student, $response);

    }


    /** @test */
    public function update()
    {
        $student = factory(Student::class)->create();
        $newData = self::makeNewStudentRequestData();

        //call
        $response = $this->put($this->route . '/' . $student->id, $newData);

        //check
        $response->assertStatus(200);
        $this->assertDatabaseHas('students', [
            'last_name' => $student->lastName,
            'first_name' => $student->firstName,
            'student_identifier' => $student->studentIdentifier,
            'email' => $student->email
        ]);


    }

    /** @test */
    public function destroy()
    {
        $student = factory(Student::class)->create();

        //call
        $response = $this->delete($this->route . '/' . $student->id);

        //check
        $response->assertStatus(200);

        $this->assertDatabaseMissing('students', [
            'last_name' => $student->lastName,
            'first_name' => $student->firstName,
            'student_identifier' => $student->studentIdentifier,
            'email' => $student->email
        ]);
    }

}
