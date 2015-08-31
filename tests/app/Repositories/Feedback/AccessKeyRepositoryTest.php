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

        $ak = AccessKey::where('exam_id', $this->exam->id)->where('student_id', $this->student->id)->first();
        if ($ak)
        {
            $ak->delete();
        }

    }


    /**
     * Deletes any existing record and then creates an entry in the db with
     * an access key for the $this->student which expires tomorrow
     *
     */
    public function createAccessKeyRecordForTest($expired = false)
    {
        //setup
        $this->expiration_date = ($expired ? Carbon::yesterday() : Carbon::tomorrow());

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
        $ak = AccessKey::where('exam_id', $this->exam->id)->where('student_id', $this->student->id)->first();
        if ($ak)
        {
            $ak->delete();
        }

        $result = $this->object->createAccessKey($this->exam->id, $this->student->id);

        $this->assertNotEmpty($result);
    }


    public function testRetrieveFeedback()
    {
        $f = Feedback::all()->random();
        $result = $this->object->retrieveFeedback($f->access_key);

        //check
        $this->assertInstanceOf('App\Feedback', $result);
        $this->assertEquals($f->content, $result->content);
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

}
