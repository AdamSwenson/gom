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

    public $keyObject;
    protected $object;
    public $expiration_date;
    public $key;
    protected $exam;
    protected $student;

    public function setUp()
    {
        parent::setUp();
        $this->object = new AccessKeyRepository;
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

        //make an access key object with the specified expiration date
        $this->keyObject = factory(AccessKey::class)->create(['access_expires' => $this->expiration_date]);
        //store the key's properties in various fields
        $this->key = $this->keyObject->access_key;
        $this->exam = Exam::find($this->keyObject->exam_id);
        $this->student = Student::find($this->keyObject->student_id);

        //Create feedback record
        factory(Feedback::class)->create(['access_key' => $this->key]);

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
        $exam = factory(Exam::class)->create();
        $key = factory(AccessKey::class, 5)->create(['exam_id' => $exam->id]);

        $expectedKeys = [];
        foreach ( $key as $k ){
            $expectedKeys[] = $k->access_key;
        }

        //call
        $result = $this->object->getAccessKeysForExam($exam->id);

        //check
        $this->assertNotNull($result);
        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
        foreach ( $result as $item ){
            $this->assertTrue(in_array($item->access_key, $expectedKeys));
        }
    }


    public function testCreateAccessKey()
    {
        //Prep
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();

        //Call
        $result = $this->object->createAccessKey($exam->id, $student->id);

        //Check
        $this->assertNotEmpty($result);
        $this->assertDatabaseHas('access_keys', ['exam_id' => $exam->id, 'student_id' => $student->id]);
    }


    public function testRetrieveFeedback()
    {
        $k = factory(AccessKey::class)->create();
        $f = factory(Feedback::class)->create(['access_key' => $k->access_key]);
        //$f = Feedback::all()->random();
        $result = $this->object->retrieveFeedback($k->access_key);

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
        $this->assertDatabaseHas('access_keys', ['access_key' => $this->key]);

        //call
        $this->object->removeAccessKey($this->key);

        //check
        $this->assertDatabaseMissing('access_keys', ['access_key' => $this->key]);
    }


    public function testRemoveAccessForExam()
    {
        //Prep
        $this->createAccessKeyRecordForTest();
        $this->assertDatabaseHas('access_keys', ['access_key' => $this->key]);

        //Call
        $this->object->removeAccessForExam($this->exam->id);

        //Check
        $this->assertDatabaseMissing('access_keys', ['exam_id' => $this->exam->id]);
        //make sure delete cascaded to feedback table
        $this->assertDatabaseMissing('feedback', ['access_key' => $this->key]);
    }


    public function testRemoveAccessForStudent()
    {
        //Prep
        $this->createAccessKeyRecordForTest();
        $this->assertDatabaseHas('access_keys', ['access_key' => $this->key]);

        //Call
        $this->object->removeAccessForStudent($this->exam->id, $this->student->id);

        //Check
        $this->assertDatabaseMissing('access_keys', ['exam_id' => $this->exam->id, 'student_id' => $this->student->id]);
        //check deletion of key separately to help disentangle possible errors
        $this->assertDatabaseMissing('access_keys', ['access_key' => $this->key]);
        //make sure delete cascaded to feedback table
        $this->assertDatabaseMissing('feedback', ['access_key' => $this->key]);
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
