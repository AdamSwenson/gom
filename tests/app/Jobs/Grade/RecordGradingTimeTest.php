<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/15/16
 * Time: 4:06 PM
 */

namespace App\Jobs\Grade;


use App\Exam;
use App\GradingTime;
use App\Http\Requests\GradingRequest;
use App\Jobs\RecordGradingTime;
use App\Student;
use App\User;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class RecordGradingTimeTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->exam = factory(Exam::class)->create();
        $this->studentId = factory(Student::class)->create()->id;
        $this->time = Factory::create()->randomFloat(2, 0, 102);
    }

    /** @test  */
    public function handleHappyPath(){
        $request = new GradingRequest();
        $request['student_id'] = $this->studentId;
        $request['time'] = $this->time;

//        $daoMock = $this->createMock(IGradingTimeRepository::class);
//        $daoMock->shouldReceive('record')
//            ->with($this->exam, $this->studentId, $this->time)
//            ->andReturn(true);

        $this->object = new RecordGradingTime($this->exam, $request);
        $result = $this->object->handle();

        $this->assertInstanceOf(GradingTime::class, $result, "returns instance of grading time");
        $this->assertEquals($this->time, $result->seconds, 0.000001);
        $this->assertEquals($this->studentId, $result->student->id);
    }

    /** @test  */
    public function handleProblemCasesStudentIdNotSet(){

        $request = new GradingRequest();
        $request['student_id'] = null;
        $request['time'] = $this->time;
//
//        $daoMock = $this->createMock(IGradingTimeRepository::class);
//        $daoMock->shouldReceive('record')->with($this->exam, null, $this->time)
//            ->andReturn(true);

        $this->object = new RecordGradingTime($this->exam, $request);
        $result = $this->object->handle();

        $this->assertFalse($result);
        $this->assertNotInstanceOf(GradingTime::class, $result, "returns instance of grading time");
    }


    /** @test  */
    public function handleProblemCasesTimeNotSet(){
        $request = new GradingRequest();
        $request['student_id'] = $this->studentId;
        $request['time'] = null;

//        $daoMock = $this->createMock(IGradingTimeRepository::class);
//        $daoMock->shouldReceive('record')->with($this->exam, $this->studentId, null)
//            ->andReturn(f);

        $this->object = new RecordGradingTime($this->exam, $request);
        $result = $this->object->handle();

        $this->assertFalse($result);
        $this->assertNotInstanceOf(GradingTime::class, $result, "returns instance of grading time");
    }


    /** @test
     @expectedException Illuminate\Auth\Access\AuthorizationException */
    public function unauthorizedUser()
    {
        $newUser = factory(User::class)->create();
        Auth::logInUsingId($newUser->id);

        $request = new GradingRequest();
        $request['student_id'] = $this->studentId;
        $request['time'] = null;

        $this->object = new RecordGradingTime($this->exam, $request);
        $this->object->handle();
    }
}
