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

class StudentRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new StudentRepository;
        $this->exam =Exam::all()->random();
        $this->student = Student::all()->random();
    }

    /**
     * @covers \App\classes\RequestHandlers\dao\StudentDao::load_students_by_exam
     */
    public function testLoad_students_by_exam()
    {
        $kumi = Kumi::all()->random();
        $kumi->exams()->attach($this->exam);
        $kumi->students()->attach($this->student);
        $kumi->push();

        $result = $this->object->load_students_by_exam($this->exam->getId());
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");

//        $kumiIds = DB::table('kumi_student')->lists('kumi_id');
        //      DB::table('exam_kumi')->where('kumi_id', $kumiIds)->lists('exam_id');

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
        public function testCreate_studentEmailNull(){}
        public function testCreate_studentStudentIdNull(){}
        public function testCreate_studentPreexistingStudent(){}
    */

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
        $sid = $this->student->student_identifier;
        $result = $this->object->load_student_by_sid($sid);
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
        $sid = $this->student->id;
        $studentId = $this->student->student_identifier;
        $this->assertEquals(1, $this->object->delete_student_by_sid($studentId));
        $this->assertEmpty(Student::find($sid));
    }

    public function testLookup_autocomplete()
    {
        //$examId, $param);
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
