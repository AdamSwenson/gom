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
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class StudentRepositoryTest extends \TestCase
{

    public $studentIds;
    public $students;
    public $kumi;
    public $exam;
    public $student;
    protected $object;
    public $testData = [];
    public $expectedDbEntries = [];
    public $request;
    public $row;

    public function setUp()
    {
        \Mockery::close();
        parent::setUp();
        $this->object = new StudentRepository;
        $this->exam = Exam::all()->random();
        $this->student = Student::all()->random();
        $this->row = 1;
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
    public function buildTestDataAndRequest($numberNew = 10, $numberOriginal = 0, $numberAltered = 0)
    {
        //Make enough preexisting students to cover the needs for unaltered and altered
        $numberPreexisting = $numberOriginal + $numberAltered;
        //Create new exam so have blank slate of students
        $this->exam = factory(Exam::class)->create();
        $students = factory(Student::class, $numberPreexisting)->create();

        $row = 1; //fieldnames contain this row number

        for ( $i = 1; $i <= $numberNew; $i++ )
        {
            //make new records using factory to ensure have correct values (not saving them to db)
            $s = factory(Student::class)->make();
            $studentIdentifier = $s->student_identifier;
            $firstName = $s->first_name;
            $lastName = $s->last_name;
            $email = $s->email;

            $this->testData[] = [
                "id$row"                => 0,
                "studentIdentifier$row" => $studentIdentifier,
                "lastName$row"          => $lastName,
                "firstName$row"         => $firstName,
                "email$row"             => $email,
            ];

            $this->expectedDbEntries[] = [
                'student_identifier' => $studentIdentifier,
                'last_name'          => $lastName,
                'first_name'         => $firstName,
                'email'              => $email,
            ];
            $row++;
        }

        //Populate with preexisting student records and save them
        if ( $numberOriginal > 0 )
        {
            for ( $i = 1; $i <= $numberOriginal; $i++ )
            {
                $student = $students->pop();

                $identifier = $student->getStudentId() ? $student->getStudentId() : '';

                $this->testData[] = [
                    "id$row"                => $student->getId(),
                    "studentIdentifier$row" => $identifier,
                    "lastName$row"          => $student->last_name,
                    "firstName$row"         => $student->first_name,
                    "email$row"             => $student->getEmail(),
                ];

                $this->expectedDbEntries[] = [
                    "id"         => $student->getId(),
                    "last_name"  => $student->last_name,
                    "first_name" => $student->first_name,
                    //   "student_identifier" => $identifier,
                    //   "email" => $student->getEmail()
                ];

                $row++;
            }
        }

        if ( $numberAltered > 0 )
        {
            //doing this so that won't have a student from both the
            //original and altered arrays
            for ( $i = 1; $i <= $numberOriginal; $i++ )
            {
                $student = $students->pop();

                //make new records using factory to ensure have correct values (not saving them to db)
                $s = factory(Student::class)->make();
                $studentIdentifier = $s->student_identifier;
                $firstName = $s->first_name;
                $lastName = $s->last_name;
                $email = $s->email;

//                $studentIdentifier = $this->faker->numberBetween(1111111, 9999999);
//                $firstName = $this->faker->firstName;
//                $lastName = $this->faker->lastName;
//                $email = $this->faker->email;

                $this->testData[] = [
                    "id$row"                => $student->getId(),
                    "studentIdentifier$row" => $studentIdentifier,
                    "lastName$row"          => $lastName,
                    "firstName$row"         => $firstName,
                    "email$row"             => $email,
                ];

                $this->expectedDbEntries[] = [
                    'id'         => $student->getId(),
                    //'student_identifier' => $studentIdentifier,
                    'last_name'  => $lastName,
                    'first_name' => $firstName,
                    //  'email' => $email
                ];
                $row++;
            }

        }

        //Build the request
        $request = new StudentRequest();
        foreach ( $this->testData as $d )
        {
            foreach ( $d as $k => $v )
            {
                $request[ $k ] = $v;
            }
        }

        return $request;
    }


    public function addToRequest($student)
    {
        if ( empty($this->request) )
        {
            //Create the request
            $this->request = new StudentRequest();
            //make sure row is reset
            $this->row = 1;
        }
        $studentIdentifier = $student->student_identifier;
        $firstName = $student->first_name;
        $lastName = $student->last_name;
        $email = $student->email;

        $this->request["id{$this->row}"] = 0;
        $this->request["studentIdentifier{$this->row}"] = $studentIdentifier;
        $this->request["lastName{$this->row}"] = $lastName;
        $this->request["firstName{$this->row}"] = $firstName;
        $this->request["email{$this->row}"] = $email;


        $this->expectedDbEntries[] = [
            'student_identifier' => $studentIdentifier,
            'last_name'          => $lastName,
            'first_name'         => $firstName,
            'email'              => $email,
        ];

        $this->row++;
    }

//    public function setupExamWithStudents()
//    {
//        $this->kumi = factory(Kumi::class)->create();
//        $this->exam = factory(Exam::class)->create();
//        $this->kumi->exams()->attach($this->exam);
//        //create students and put in expected order
//        $this->students = factory(Student::class, 5)->create();
//        $this->students = $this->students->sortBy('last_name');
//        $this->studentIds = [];
//        foreach ( $this->students as $item )
//        {
//            $this->kumi->students()->attach($item);
//            $this->studentIds[] = $item->id;
//        }
//        $this->kumi->push();
//    }

    /**
     * @covers \App\Repositories\Student\StudentRepository::load_students_by_exam
     */
    public function testLoad_students_by_exam()
    {
        # prep
        $fixture = $this->setupExamWithStudents();

        # call
        //case where loading from id
        $result1 = $this->object->load_students_by_exam($fixture['exam']->id);
        //case where loading from object
        $result2 = $this->object->load_students_by_exam($fixture['exam']);

        # check
        //check results of loading by id
        $result1Ids = [];
        $this->assertNotEmpty($result1);
        $this->assertEquals(sizeof($fixture['studentIds']), sizeof($result1), "Number of students as expected");
        foreach ( $result1 as $r )
        {
            $result1Ids[] = $r->id;
            $this->assertInstanceOf('\App\Student', $r, "returns a student object");
            $this->assertTrue(in_array($r->id, $fixture['studentIds']), "Student id is in the expected array");
        }

        $this->assertNotEmpty($result2);
        $this->assertEquals(sizeof($fixture['studentIds']), sizeof($result2), "Number of students as expected");

        //check results of loading from exam
        $result2Ids = [];
        foreach ( $result2 as $r )
        {
            $result2Ids[] = $r->id;
            $this->assertInstanceOf('\App\Student', $r, "returns a student object");
            $this->assertTrue(in_array($r->id, $fixture['studentIds']), "Student id is in the expected array");
        }

        //Check sort order 
        for ( $i = 0; $i < sizeof($this->students); $i++ )
        {
            $this->assertEquals($fixture['studentIds'][ $i ], $result1Ids[ $i ]);
            $this->assertEquals($fixture['studentIds'][ $i ], $result2Ids[ $i ]);
        }

    }

    public function testCreate_student()
    {
        #prep
        $lastName = $this->faker->lastName();
        $firstName = $this->faker->firstName();
        $studentId = $this->faker->randomNumber(9);
        $email = $this->faker->unique()->email();

        #call
        $result = $this->object->create_student($lastName, $firstName, $studentId, $email);

        #check
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
        $lastName = $this->faker->unique()->lastName();
        $firstName = $this->faker->unique()->firstName();
        $studentId = $this->faker->unique()->randomNumber(9);

        //call
        $result = $this->object->create_student($lastName, $firstName, $studentId);

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $this->seeInDatabase('students', [
            'last_name'          => $lastName,
            'first_name'         => $firstName,
            'student_identifier' => $studentId,
        ]);
    }

    /**
     * @test
     */
    public function create_student_who_already_exists_but_for_different_user()
    {
        $student = Student::all()->random();
        $user = factory(User::class)->create();

        \Auth::loginUsingId($user->id);

        //call
        $result = $this->object->create_student(
            $student->last_name,
            $student->first_name,
            $student->getStudentId(),
            $student->getEmail());

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $this->seeInDatabase('students',
                             [
                                 'last_name'  => $student->last_name,
                                 'first_name' => $student->first_name,
                                 //       'student_identifier' => $this->student->student_identifier, //encrypted ok
                                 //        'email' => $this->student->email,//encrypted version ok
                                 'user_id'    => $user->id,
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
        $sid = null;
        //call
        $result = $this->object->create_student($lastName, $firstName, $sid, $email);

        //check
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");
        $s = Student::where('last_name', $lastName)
            ->where('first_name', $firstName)
            ->where('email', $email)
            ->first();

        $this->assertNotEmpty($s, 'something returned from search');
        $this->assertInstanceOf('\App\Student', $result, "returns a student object");

        $this->assertEquals($s->id, $result->id, "Looked up object has same id");

//        $this->assertEquals($s, $result);
        //       $this->seeInDatabase('students', ['last_name' => $lastName, 'first_name' => $firstName, 'email' => $email]);
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

    /**
     * todo this fails
     */
    public function testDelete_student_by_sid()
    {
        #prep
        $student = factory(Student::class)->create();
        //$student = Student::whereNotNull('student_identifier')->first();
        $sid = $student->student_identifier;
        //check has a sid
        $this->assertTrue($sid > 0);

        #call
        $result = $this->object->delete_student_by_sid($student->student_identifier);
        $this->assertEquals(1, $result);
        $this->notSeeInDatabase('students', [
            'user_id'            => self::$userid,
            'student_identifier' => $sid,
        ]);
    }


    /**
     * Returns all students associated with the user
     */
    public function testLoad_all_students()
    {
        $result = $this->object->load_all_students();
        $this->assertNotEmpty($result);
        foreach ( $result as $r )
        {
            $this->assertInstanceOf('\App\Student', $r);
            $this->assertEquals(self::$userid, $r->user_id, "Only students belonging to user loaded");
        }
    }


    public function testLoad_students_by_class()
    {
        $fixture = $this->setupExamWithStudents();
        #call
        $result = $this->object->load_students_by_class($fixture['kumi']->id);

        #check
        $this->assertInstanceOf(Collection::class, $result, "returns a collection");
        $this->assertEquals(count($fixture['studentIds']), count($result), "expected number of students returned");
        foreach ( $result as $r )
        {
            $this->assertInstanceOf(Student::class, $r, "Student object");
            $this->assertTrue(in_array($r->id, $fixture['studentIds']), "Student is expected");
        }
    }


    /* ---------------------------------------------------------- Update All tests--------------------------*/

    /**
     * @test
     */
    public function deleteStudentsNotOnRoster()
    {
        # prep
        $this->setupExamWithStudents();
        $numberToRemove = 1;
        $indexToRemove = 1;
        $initialNumberRecords = sizeof($this->students);
        $recordsInQuery = $initialNumberRecords - $numberToRemove;

        $expectedDeletedIds = [];

        for ( $i = 0; $i < $initialNumberRecords; $i++ )
        {
            if ( $i < $recordsInQuery )
            {
                $this->addToRequest($this->students[ $i ]);
            } else
            {
                $expectedDeletedIds[] = $this->students[ $i ]->id;
            }

        }

        # call
        $result = $this->object->update_all($this->exam, $this->request);

        # check
        $this->assertInstanceOf(Collection::class, $result, "returns collection");

        foreach ( $expectedDeletedIds as $id )
        {
            $this->notSeeInDatabase('students', ['id' => $id]);
        }

        foreach ( $this->expectedDbEntries as $data )
        {
            $this->seeInDatabase('students', $data);
        }
    }


    /**
     * @test
     */
    public function existingStudentMadeInvalidNotDeleted()
    {
        $this->markTestIncomplete();

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
        $this->markTestIncomplete();

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
        for ( $i = 1; $i <= $numberStudents; $i++ )
        {
            $validator->validRecords[] = $i;
        }
        $this->object->studentValidator = $validator;

        //Build a request
        $request = $this->buildTestDataAndRequest($numberStudents);

        #Call
        $this->object->updateStudentsInDatabase($request, $kumi);

        #Check
        foreach ( $this->expectedDbEntries as $data )
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
        foreach ( $this->expectedDbEntries as $data )
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
        $request = $this->buildTestDataAndRequest(0, $numberOriginal = 10);

        #Call
        $response = $this->object->update_all($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach ( $this->expectedDbEntries as $data )
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
        $request = $this->buildTestDataAndRequest(0, 0, $numberAltered = 10);

        #Call
        $response = $this->object->update_all($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach ( $this->expectedDbEntries as $data )
        {
            $this->seeInDatabase('students', $data);
        }
    }

    /**
     * @test
     */
    public function updateAllMixedHappyPath()
    {
        //All preexisting records are being updated.
        //Also 10 new records are being added

        #prep
        $request = $this->buildTestDataAndRequest(10, 10, 10);

        #Call
        $response = $this->object->update_all($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach ( $this->expectedDbEntries as $data )
        {
            $this->seeInDatabase('students', $data);
        }
    }

    /* ------------------------------ Bug squishing -------------- */

    /**
     * This is based on a bug (GOM-189)
     * @test
     */
    public function bug_deleteAllStudentsWhenIncomingRosterIsEmpty()
    {
        $this->setupExamWithStudents();

        #prep
//        $exam = Exam::find(1);
//        $existingStudents = $exam->getAllAssociatedStudents();
        //make sure there are students associated with the exam
        $this->assertTrue(count($this->students) > 0, "At least one student associated with exam");
        $emptyRequest = new StudentRequest();

        #call
        $this->object->update_all($this->exam, $emptyRequest);

        foreach ( $this->students as $s )
        {
            $this->assertTrue($s->id > 0, "stored student retains valid id (despite being removed from db");
            $this->dontSeeInDatabase('students', ['id' => $s->id]);
        }

    }


}
