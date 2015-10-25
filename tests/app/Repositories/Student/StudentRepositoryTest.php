<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 10:18 AM
 */

namespace App\Repositories\Student;


use App\Exam;
use App\Http\Controllers\helpers\validation\StudentRecordValidator;
use App\Http\Requests\StudentRequest;
use App\Kumi;
use App\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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
     * Builds test data and a StudentRequest object.
     * Also creates a new exam and sets it to $this->exam
     *
     * @param int $numberNew Number of brand new students to have in request
     * @param int $numberOriginal Number of existing unaltered students to have in request
     * @param int $numberAltered Number of existing students with fields altered to have in request
     * @return StudentRequest
     */
    public function buildTestDataAndRequest($numberNew=10, $numberOriginal=0, $numberAltered=0)
    {
        //Create new exam so have blank slate of students
        $this->exam = new \App\Exam();
        $this->exam->setYear($this->faker->year);
        $this->exam->setTerm('Fall');
        $this->exam->setName($this->faker->word);
        $this->exam->save();

        for($i=1; $i<=$numberNew; $i++)
        {
            $studentIdentifier = $this->faker->numberBetween(1111111, 9999999);
            $firstName = $this->faker->firstName;
            $lastName = $this->faker->lastName;
            $email = $this->faker->email;

            $this->testData[] = [
                "id$i" => 0,
                "studentIdentifier$i" => $studentIdentifier,
                "lastName$i" => $lastName,
                "firstName$i" => $firstName,
                "email$i" => $email];

            $this->expectedDbEntries[] = [
                'student_identifier' => $studentIdentifier,
                'last_name' => $lastName,
                'first_name' => $firstName,
                'email' => $email
            ];
        }

        if( $numberOriginal > 0 )
        {
            for($i=1; $i<= $numberOriginal; $i++)
            {
                $student = Student::all()->random();

                $identifier = $student->getStudentId() ? $student->getStudentId() : '';

                $this->testData[] = [
                    "id$i" => $student->getId(),
                    "studentIdentifier$i" => $identifier,
                    "lastName$i" => $student->last_name,
                    "firstName$i" => $student->first_name,
                    "email$i" => $student->getEmail()
                ];

                $this->expectedDbEntries[] = [
                    "id" => $student->getId(),
                    "last_name" => $student->last_name,
                    "first_name" => $student->first_name,
                 //   "student_identifier" => $identifier,
                 //   "email" => $student->getEmail()
                ];
            }
        }

        if( $numberAltered > 0 )
        {
            $student = Student::all()->random();
            $studentIdentifier = $this->faker->numberBetween(1111111, 9999999);
            $firstName = $this->faker->firstName;
            $lastName = $this->faker->lastName;
            $email = $this->faker->email;

            $this->testData[] = [
                "id$i" => $student->getId(),
                "studentIdentifier$i" => $studentIdentifier,
                "lastName$i" => $lastName,
                "firstName$i" => $firstName,
                "email$i" => $email];

            $this->expectedDbEntries[] = [
                'id' => $student->getId(),
                //'student_identifier' => $studentIdentifier,
                'last_name' => $lastName,
                'first_name' => $firstName,
              //  'email' => $email
            ];

        }

        //Build the request
        $request = new StudentRequest();
        foreach($this->testData as $d)
        {
            foreach ($d as $k => $v)
            {
                $request[$k] = $v;
            }
        }
        return $request;
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
        $this->assertEquals($studentId, $check->getStudentId());
    }


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
//        $this->seeInDatabase('students', ['last_name' => $lastName, 'first_name' => $firstName, 'student_identifier' => Crypt::encrypt($studentId)]);
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
            $this->student->getStudentId(),
            $this->student->getEmail());

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $this->seeInDatabase('students',
                             [
                                 'last_name' => $this->student->last_name,
                                 'first_name' => $this->student->first_name,
                          //       'student_identifier' => $this->student->student_identifier, //encrypted ok
                         //        'email' => $this->student->email,//encrypted version ok
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
//        $this->seeInDatabase('students', ['last_name' => $lastName, 'first_name' => $firstName, 'email' => Crypt::encrypt($email)]);
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
        $sid = $student->getStudentId();
        $result = $this->object->load_student_by_sid($sid);
        $this->assertNotEmpty($result, 'returned object');
        $this->assertInstanceOf('\App\Student', $result);
        $this->assertEquals($student, $result);
    }


    public function testUpdate_email()
    {
        $new = $this->faker->email();
        $result = $this->object->update_email($this->student->id, $new);
        $this->assertNotEmpty($result, 'returned object');
        $this->assertInstanceOf('\App\Student', $result);
        $this->assertEquals($new, $result->getEmail());

        $check = Student::find($this->student->id);
        $this->assertNotEmpty($check, 'returned object');
        $this->assertInstanceOf('\App\Student', $check);
        $this->assertEquals($new, $check->getEmail(), "email updated");
    }


    public function testDelete_student_by_id()
    {
        $sid = $this->student->id;
        $this->assertEquals(1, $this->object->delete_student_by_id($sid));

        $this->assertEmpty(Student::find($sid));
    }


    public function testDelete_student_by_sid()
    {
        //TODO Fix this query
        $student = Student::whereNotNull('student_identifier')->first();
        // Student::where('student_identifier', '!=', null)->first();
      //  $student = Student::where('student_identifier', '!=', null)->first();

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


/* ---------------------------------------------------------- Update All tests--------------------------*/

    /**
     * @test
     */
    public function deleteStudentsNotOnRoster()
    {
        $indexToRemove = 1;

        # prep
        $request = $this->buildTestDataAndRequest(0, 10, 0);
        $recordToRemove = $this->expectedDbEntries[$indexToRemove];
        unset($this->expectedDbEntries[$indexToRemove]);
        unset($request['id' . $indexToRemove]);
        unset($request['last_name' . $indexToRemove]);
        unset($request['first_name' . $indexToRemove]);
        unset($request['student_identifier' . $indexToRemove]);
        unset($request['email' . $indexToRemove]);

        # call
        $result = $this->object->update_all($this->exam, $request);

        # check
        $this->assertNotEmpty($result);
        $this->notSeeInDatabase('students', $recordToRemove);

        foreach($this->expectedDbEntries as $data)
        {
            $this->seeInDatabase('students', $data, "non deleted student still in db");
        }
    }



    /**
     * @test
     */
    public function existingStudentMadeInvalidNotDeleted()
    {



        //check
        //assert: the record of the student was not deleted
        //assert: the record was not updated with the invalid info
        //assert: the returned allStudents array had a 'failed' field for the bad record
    }

    /**
     *
     */
    public function newStudentWasInvalid()
    {


        //assert: not written to database
        //assert : returned allStudents array has the bad record with a 'failed' field
    }

    /**
     * @test
     */
    public function updateStudentsInDatabaseHappyPath()
    {
        $numberStudents = 10;
        #Prep
        $kumi = Kumi::all()->random();
        $exam = $kumi->exams()->first();
        $this->object->exam = $exam;
        //push row numbers into validRecords array
        $validator = new StudentRecordValidator();
        for($i=1; $i<=$numberStudents; $i++)
        {
            $validator->validRecords[] = $i;
        }
        $this->object->studentValidator = $validator;

        //Build a request
        $request = $this->buildTestDataAndRequest($numberStudents);

        #Call
        $this->object->updateStudentsInDatabase($request, $kumi);

        #Check
        foreach($this->expectedDbEntries as $data)
        {
            $this->seeInDatabase('students', $data);
        }

    }


    /**
     * @test
     */
    public function updateAllOnlyNewHappyPath()
    {
        #prep
        $request = $this->buildTestDataAndRequest();

        #Call
        $response = $this->object->update_all($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach($this->expectedDbEntries as $data)
        {
            $this->seeInDatabase('students', $data);
        }
    }

    /**
     * @test
     */
    public function updateAllOnlyUnalteredHappyPath()
    {
        #prep
        $request = $this->buildTestDataAndRequest(0, $numberOriginal=10);

        #Call
        $response = $this->object->update_all($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach($this->expectedDbEntries as $data)
        {
            $this->seeInDatabase('students', $data);
        }
    }

    /**
     * @test
     */
    public function updateAllOnlyAlteredHappyPath()
    {
        #prep
        $request = $this->buildTestDataAndRequest(0, 0, $numberAltered=10);

        #Call
        $response = $this->object->update_all($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach($this->expectedDbEntries as $data)
        {
            $this->seeInDatabase('students', $data);
        }
    }

    /**
     * @test
     */
    public function updateAllMixedHappyPath()
    {
        #prep
        $request = $this->buildTestDataAndRequest(10, 10, 10);

        #Call
        $response = $this->object->update_all($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach($this->expectedDbEntries as $data)
        {
            $this->seeInDatabase('students', $data);
        }
    }



}
