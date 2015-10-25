<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 11:05 AM
 */

namespace App\HTTP\Controllers;


use App\Http\Controllers\helpers\validation\StudentRecordValidator;
use App\Http\Requests\StudentRequest;
use App\Kumi;
use App\Student;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Mockery\Mock;

class StudentControllerTest extends \TestCase
{
    use WithoutMiddleware;

    public $expectedDbEntries = [];

    public $exam;

    public $testData = [];

    public $student;
//    public $dao;
    protected $object;

    public function setUp()
    {
//        \Mockery::close();
        parent::setUp();
        $this->student = Student::all()->random();
        // $this->dao = \Mockery::mock('\App\Repositories\Student\IStudentRepository');
        //$this->app->instance('\App\Repositories\Student\IStudentRepository', $this->dao);
//        $this->dao = $this->createMock('\App\Repositories\Student\IStudentRepository');
         $this->object = new StudentController();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
//        parent::tearDown();
        \Mockery::close();
    }


    public function testIndex()
    {
        $response = $this->action('GET', 'StudentController@index');
        $this->assertNotNull($response);
    }

/*    public function testCreate()
    {
        $this->markTestIncomplete();
    }*/


    public function testStore()
    {
        //TODO Improve this test by testing for the values being passed around

        $numStudents = 3;
        $processor_mock = $this->createMock('App\Jobs\StudentImport\IImportStudentsFromCsv');
        $processor_mock->shouldReceive('handle')
            ->andReturn(Student::all()->random($numStudents));

        $kumi_repository_processor_mock = $this->createMock('App\Repositories\Student\IKumiRepository');
        $kumi_repository_processor_mock
            ->shouldReceive('create')->andReturn(Kumi::all()->random());

        $dao = $this->createMock('App\Repositories\Student\IStudentRepository');
        $dao->shouldReceive('create_student')
            ->times($numStudents)
            ->andReturn(Student::all()->random());

        $data = [
            'exam_id' => 1,
            'lastName' => $this->faker->lastName(),
            'firstName' => $this->faker->firstName(),
            'studentId' => $this->faker->randomNumber(9),
            'email' => $this->faker->email()
        ];

        $response = $this->action('POST', 'StudentController@store', $data);
        $this->assertNotNull($response);
    }


    public function testShow()
    {
        $dao = $this->createMock('\App\Repositories\Student\IStudentRepository');

        $dao->shouldReceive('load_student_by_id')->with($this->student)->andReturn($this->student);
        $response = $this->action('GET', 'StudentController@show', $this->student);
        $this->assertNotNull($response);
    }

//
//    public function testEdit()
//    {
//        //
//    }
//
//
//    public function testUpdate()
//    {
//        //
//    }

    public function testDestroy()
    {
        $dao = $this->createMock('\App\Repositories\Student\IStudentRepository');
        $dao->shouldReceive('delete_student_by_object')->with($this->student)->andReturn(true);
        $response = $this->action('DELETE', 'StudentController@destroy', $this->student);
        $this->assertNotNull($response);
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
                    "student_identifier" => $identifier,
                    "email" => $student->getEmail()
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
                'student_identifier' => $studentIdentifier,
                'last_name' => $lastName,
                'first_name' => $firstName,
                'email' => $email
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
     * @test
     */
    public function updateDatabase()
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

//        foreach($this->testData as $k => $v)
//        {
//            $request[$k] = $v;
//        }

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
        $response = $this->object->updateAll($this->exam, $request);

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
        $response = $this->object->updateAll($this->exam, $request);

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
        $response = $this->object->updateAll($this->exam, $request);

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
        $response = $this->object->updateAll($this->exam, $request);

        #Check
        $this->assertNotNull($response);
        foreach($this->expectedDbEntries as $data)
        {
            $this->seeInDatabase('students', $data);
        }
    }




//
//    /**
//     * @test
//     */
//    public function validateStudentsEverythingFine()
//    {
//        //prep
//        $data = [
//            [
//                'lastName1' => 'smith',
//                'firstName1' => 'jill',
//                'email1' => 'jill@smith.com',
//                'studentIdentifier1' => '1234567',
//                'id1' => '200'],
//            [ 'lastName2' => 'jillson',
//                'firstName2' => 'smitty',
//                'email2' => 'smitty@jill.com',
//                'studentIdentifier2' => '7654321',
//                'id2' => '201']
//            ];
//
//        $request = new Request();
//        $request->replace($data);
//        $this->assertEquals($data, $request->all());
//
//        //call
//        $this->object->validateStudents($request);
//
////        $this->action('POST', 'StudentController@validateStudents', $data);
//
//        //check
//        $this->assertAttributeContains(200, 'validRecords', $this->object, 'Id 200 in validRecords');
//        $this->assertAttributeContains('201', 'validRecords', $this->object, 'Id 201 in validRecords');
//
//    }
}
