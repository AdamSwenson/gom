<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 10:42 AM
 */

namespace App;


use Carbon\Carbon;

class StudentTest extends \TestCase
{
    public $expiration_date;
    protected $object;
    protected $student;
    protected $exam;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Student;
        $this->student = Student::all()->random();
        $this->exam = Exam::all()->random();
    }

    public function testSetEmail()
    {
        $test = $this->faker->email();
        $this->object->setEmail($test);
        $this->assertEquals($test, $this->object->email);
    }


    /**
     * Deletes any existing record and then creates an entry in the db with
     * an access key for the $this->student which expires tomorrow
     *
     */
    public function createAccessKeyRecordForTest( $expired = false )
    {
        //setup
        $this->expiration_date = ($expired ? Carbon::yesterday() : Carbon::tomorrow());

        $a = AccessKey::where('exam_id', $this->exam->id)->where('student_id', $this->student->id)->first();
        if ( !is_null($a) ) {
            $a->delete();
        }

        $ak = new AccessKey();
        $ak->setExamId($this->exam->id);
        $ak->setStudentId($this->student->id);
        $ak->setKey($this->faker->md5());
        $ak->setExpirationDate($this->expiration_date);
        $ak->save();

        $this->assertDatabaseHas('access_keys', [
            'exam_id' => $this->exam->id,
            'student_id' => $this->student->id
        ]);


    }

//    public function feedbackEmailSent_returns_date_when_sent($examId)
//    {
//    }

    /**
     * @test
     */
    public function hasBeenGradedWhenNotGraded()
    {
        $examId = Exam::all()->random()->id;
        $student = factory(Student::class)->create();
        $result = $student->hasBeenGraded($examId);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function hasBeenGradedWhenGraded()
    {
        $qa = QuestionAssignment::all()->random();
        $e = $qa->exam;
        $examId = $qa->getExamId();
        $student = factory(Student::class)->create();
        $this->assertFalse($student->hasBeenGraded($examId));

        $query = <<<MYSQL
        INSERT INTO question_scores (question_assignment_id, student_id, score)
        VALUES (:qaId, :sid, 45.2);
MYSQL;

        $values = ['qaId' => $qa->id, 'sid' => $student->id];
        \DB::insert($query, $values);

        $this->assertTrue($student->hasBeenGraded($examId));
    }

    /**
     * @test
     */
    public function isFeedbackAvailable_returns_true_when_now_is_before_expiration_date()
    {
        //prep
        $this->createAccessKeyRecordForTest();

        //call
        $this->assertTrue($this->student->isFeedbackAvailable($this->exam->id));
    }

    /**
     * @test
     */
    public function isFeedbackAvailable_returns_false_when_now_is_before_expiration_date()
    {
        //prep
        $this->createAccessKeyRecordForTest(true);

        //call
        $result = $this->student->isFeedbackAvailable($this->exam->id);

        //check
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function getFeedbackAccessExpirationDate_returns_date_before_expiration()
    {
        //prep
        $this->createAccessKeyRecordForTest();

        //call
        $result = $this->student->getFeedbackAccessExpirationDate($this->exam->id);

        //check
        $this->assertInstanceOf('Carbon\Carbon', $result);
        $this->assertTrue($this->expiration_date->eq($result));
    }

    /** @test */
    public function getGradingTimeOnExam()
    {
        $gradingTime = factory(GradingTime::class)->create();
        $student = Student::find($gradingTime->student_id);
        $exam = $gradingTime->exam;

        //call
        $result = $student->getGradingTimeOnExam($exam);
        $this->assertInstanceOf(GradingTime::class, $result, 'Returns grading time object');

        $this->assertEquals($gradingTime->seconds, $result->seconds, "Returns the expected grading time object");
    }

#-------- foreign keys

    /** @test */
    public function gradingTimes()
    {
        $gradingTime = factory(GradingTime::class)->create();
        $student = Student::find($gradingTime->student_id);

        //call
        foreach ( $student->gradingTimes as $g ) {
            $this->assertInstanceOf(GradingTime::class, $g);
        };
    }

    public function testsKumis()
    {
        foreach ( $this->student->kumis as $r ) {
            $this->assertInstanceOf('App\Kumi', $r);
        }
    }

//    public function testExams()
//    {
//        foreach($this->student->exams as $r)
//        {
//            $this->assertInstanceOf('App\Exam', $r);
//        }
//    }

    public function testUser()
    {
        $this->assertInstanceOf('App\User', $this->student->user);
    }
}
