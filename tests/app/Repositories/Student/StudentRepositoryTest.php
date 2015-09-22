<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 10:18 AM
 */

namespace App\Repositories\Student;


use App\Exam;
use App\Kumi;
use App\Student;
use Illuminate\Support\Facades\Auth;

class StudentRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {    \Mockery::close();
        parent::setUp();
        $this->object = new StudentRepository;
        $this->exam =Exam::all()->random();
        $this->student = Student::all()->random();
    }
public function tearDown()
{
    \Mockery::close();
}
    /**
     * @covers \App\Repositories\Student\StudentRepository::load_students_by_exam
     */
    public function testLoad_students_by_exam()
    {
        $kumi = Kumi::all()->random();
        $kumi->exams()->attach($this->exam);
        $kumi->students()->attach($this->student);
        $kumi->push();

        $result = $this->object->load_students_by_exam($this->exam->getId());
        $this->assertNotEmpty($result);
        foreach($result as $r)
        {
            $this->assertInstanceOf('\App\Student', $r, "returns a student object");
        }

    }

    public function testCreate_student()
    {
        $lastName = $this->faker->lastName();
        $firstName = $this->faker->firstName();
        $studentId = $this->faker->randomNumber(9);
        $email = $this->faker->unique()->email();

        $result = $this->object->create_student($lastName, $firstName, $studentId, $email);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");

        $check = Student::find($result->getId());
        $this->assertEquals($lastName, $check->last_name);
        $this->assertEquals($firstName, $check->first_name);
        $this->assertEquals($studentId, $check->student_identifier);
    }

    /*    Todo Implement important test cases

        public function testCreate_studentPreexistingStudent(){}
    */

    /**
     * @test
     */
    public function create_student_with_no_email()
    {
        //prep
        $lastName = $this->faker->lastName();
        $firstName = $this->faker->firstName();
        $studentId = $this->faker->randomNumber(9);

        //call
        $result = $this->object->create_student($lastName, $firstName, $studentId);

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $this->seeInDatabase('students', ['last_name' => $lastName, 'first_name' => $firstName, 'student_identifier' => $studentId]);
     }

    /**
     * @test
     */
    public function create_student_who_already_exists_but_for_different_user()
    {
        $userId = 2;

        \Auth::loginUsingId($userId);

        //call
        $result = $this->object->create_student(
            $this->student->last_name,
            $this->student->first_name,
            $this->student->student_identifier,
            $this->student->email);

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $this->seeInDatabase('students',
                             [
                                 'last_name' => $this->student->last_name,
                                 'first_name' => $this->student->first_name,
                                 'student_identifier' => $this->student->student_identifier,
                                 'email' => $this->student->email,
                                 'user_id' => $userId
                             ]);

        //cleanup: log back in as normal
        \Auth::loginUsingId(self::$userid);
    }

    /**
     * @test
     */
    public function create_student_with_no_student_identifier()
    {
        //prep
        $lastName = $this->faker->lastName();
        $firstName = $this->faker->firstName();
        $email = $this->faker->unique()->email();

        //call
        $result = $this->object->create_student($lastName, $firstName, null, $email);

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $this->seeInDatabase('students', ['last_name' => $lastName, 'first_name' => $firstName, 'email' => $email]);
    }

    /**
     * @test
     */
    public function create_student_with_no_student_identifier_or_email()
    {
        //prep
        $lastName = $this->faker->lastName();
        $firstName = $this->faker->firstName();

        //call
        $result = $this->object->create_student($lastName, $firstName);

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $this->seeInDatabase('students', ['last_name' => $lastName, 'first_name' => $firstName]);
    }

    /*
     * Todo Enable once error handling set up
    public function testCreate_studentExceptionBadLastName(){}
    public function testCreate_studentExceptionBadFirstName(){}
    public function testCreate_studentExceptionBadStudentId(){}
    */

    public function testLoad_student_by_id()
    {
        $result = $this->object->load_student_by_id($this->student->id);
        $this->assertNotEmpty($result, 'returned object');
        $this->assertInstanceOf('\App\Student', $result);
        $this->assertEquals($this->student, $result);
    }


    public function testLoad_student_by_sid()
    {
        $student = Student::where('student_identifier', '>', 0)->first();
        $result = $this->object->load_student_by_sid($student->student_identifier);
        $this->assertNotEmpty($result, 'returned object');
        $this->assertInstanceOf('\App\Student', $result);
        $this->assertEquals($this->student, $result);
    }


    public function testUpdate_email()
    {
        $new = $this->faker->email();
        $result = $this->object->update_email($this->student->id, $new);
        $this->assertNotEmpty($result, 'returned object');
        $this->assertInstanceOf('\App\Student', $result);
        $this->assertEquals($new, $result->email);

        $check = Student::find($this->student->id);
        $this->assertNotEmpty($check, 'returned object');
        $this->assertInstanceOf('\App\Student', $check);
        $this->assertEquals($new, $check->email, "email updated");
    }

    /*
     * Todo: Add when error handling enabled
    public function testUpdate_emailExceptionBadEmail(){}
    */


    public function testDelete_student_by_id()
    {
        $sid = $this->student->id;
        $this->assertEquals(1, $this->object->delete_student_by_id($sid));

        $this->assertEmpty(Student::find($sid));
    }


    public function testDelete_student_by_sid()
    {
        $student = Student::where('student_identifier', '>', 0)->first();

        $this->assertEquals(1, $this->object->delete_student_by_sid($student->student_identifier));
        $this->notSeeInDatabase('students', ['user_id' => self::$userid, 'student_identifier' => $student->student_identifier] );
    }



    /**
     * Returns all students associated with the user
     */
    public function testLoad_all_students()
    {
        $result = $this->object->load_all_students();
        $this->assertNotEmpty($result);
        foreach($result as $r){
            $this->assertInstanceOf('\App\Student', $r);
            $this->assertEquals(self::$userid, $r->user_id, "Only students belonging to user loaded");
        }
    }


    public function testLoad_students_by_class()
    {
        //    $kumiId);
    }

}
