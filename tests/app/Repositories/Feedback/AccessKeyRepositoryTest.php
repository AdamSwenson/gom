<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 2:30 PM
 */

namespace App\Repositories\Feedback;


use App\AccessKey;
use App\Exam;
use App\Feedback;
use App\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AccessKeyRepositoryTest extends \TestCase
{

    protected $object;
    public $expiration_date;
    public $key;
    protected $exam;
    protected $student;

    public function setUp()
    {
        parent::setUp();
        $this->object = new AccessKeyRepository;
        $this->exam = Exam::all()->random();
        $this->student = Student::all()->random();

        $ak = AccessKey::where('exam_id', $this->exam->id)->where('student_id', $this->student->id)->delete();
    }


    /**
     * Deletes any existing record and then creates an entry in the db with
     * an access key for the $this->student which expires tomorrow
     * Also creates feedback record
     */
    public function createAccessKeyRecordForTest($expired = false)
    {
        //expiration date depending on parameter
        $this->expiration_date = ($expired ? Carbon::yesterday() : Carbon::tomorrow());

        //Create access key
        $a = AccessKey::where('exam_id', $this->exam->id)->where('student_id', $this->student->id)->first();
        if (!is_null($a))
        {
            $a->delete();
        }
        $this->key = $this->faker->md5();
        $ak = new AccessKey();
        $ak->setExamId($this->exam->id);
        $ak->setStudentId($this->student->id);
        $ak->setKey($this->key);
        $ak->setExpirationDate($this->expiration_date);
        $ak->save();

        //Create feedback record
        $f = Feedback::firstOrNew(['access_key' => $ak->access_key]);
        $f->content = $this->faker->text(100);
        $f->save();
    }

    public function testGetAccessKeyForStudent()
    {
        //prep
        $this->createAccessKeyRecordForTest();

        //call
        $result = $this->object->getAccessKeyForStudent($this->exam->id, $this->student->id);

        //check
        $this->assertNotNull($result);
        $this->assertEquals($this->key, $result);
    }


    public function testGetAccessKeysForExam()
    {
        //prep
        $this->createAccessKeyRecordForTest();

        //call
        $result = $this->object->getAccessKeysForExam($this->exam->id);

        //check
        $this->assertNotNull($result);
        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }


    public function testCreateAccessKey()
    {
        //Prep
        $ak = AccessKey::where('exam_id', $this->exam->id)
            ->where('student_id', $this->student->id)
            ->first();
        if ($ak)
        {
            $ak->delete();
        }

        //Call
        $result = $this->object->createAccessKey($this->exam->id, $this->student->id);

        //Check
        $this->assertNotEmpty($result);
        $this->seeInDatabase('access_keys', ['exam_id' => $this->exam->id, 'student_id' => $this->student->id]);
    }


    public function testRetrieveFeedback()
    {
        $f = Feedback::all()->random();
        $result = $this->object->retrieveFeedback($f->access_key);

        //check
        $this->assertInstanceOf('App\Feedback', $result);
        $this->assertEquals($f->content, $result->content);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function retrieveFeedback_throws_exception_when_access_key_not_in_db()
    {
        $this->object->retrieveFeedback('catfood');
    }

    /**
     * @test
     * @expectedException \App\Exceptions\InputTypeException
     */
    public function retrieveFeedback_throws_exception_when_access_key_is_too_long()
    {
        //Prep
        $badKey = 'a1';
        for($i=0; $i<=AccessKeyRepository::TRIM_TO_LENGTH; $i++)
        {
            $badKey .= 'b2';
        }
        $this->assertTrue(mb_strlen($badKey) > AccessKeyRepository::TRIM_TO_LENGTH, "Key is genuinely bad");

        //Call
        $this->object->retrieveFeedback($badKey);
    }

    public function testRemoveAccessKey()
    {
        //prep
        $this->createAccessKeyRecordForTest();
        $this->seeInDatabase('access_keys', ['access_key' => $this->key]);

        //call
        $this->object->removeAccessKey($this->key);

        //check
        $this->notSeeInDatabase('access_keys', ['access_key' => $this->key]);
    }


    public function testRemoveAccessForExam()
    {
        //Prep
        $this->createAccessKeyRecordForTest();
        $this->seeInDatabase('access_keys', ['access_key' => $this->key]);

        //Call
        $this->object->removeAccessForExam($this->exam->id);

        //Check
        $this->notSeeInDatabase('access_keys', ['exam_id' => $this->exam->id]);
        //make sure delete cascaded to feedback table
        $this->notSeeInDatabase('feedback', ['access_key' => $this->key]);
    }


    public function testRemoveAccessForStudent()
    {
        //Prep
        $this->createAccessKeyRecordForTest();
        $this->seeInDatabase('access_keys', ['access_key' => $this->key]);

        //Call
        $this->object->removeAccessForStudent($this->exam->id, $this->student->id);

        //Check
        $this->notSeeInDatabase('access_keys', ['exam_id' => $this->exam->id, 'student_id' => $this->student->id]);
        //check deletion of key separately to help disentangle possible errors
        $this->notSeeInDatabase('access_keys', ['access_key' => $this->key]);
        //make sure delete cascaded to feedback table
        $this->notSeeInDatabase('feedback', ['access_key' => $this->key]);
    }



    public function testGetStudentInfo(){
        #Prep
        $examId = factory(Exam::class)->create()->id;
        $student = Student::all()->random();
        $hash = $this->object->createAccessKey($examId, $student->id);
        $key = AccessKey::where('access_key', $hash)->first();
        $this->assertInstanceOf(AccessKey::class, $key );

        #Call
        $result = $this->object->getStudentInfo($key);

        #Check
        $this->assertTrue(is_array($result));
        $this->assertEquals($student->getFullName(), $result['studentName'] );
        $this->assertEquals($student->student_identifier, $result['studentIdentifier']);
    }

}
