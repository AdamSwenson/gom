<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 2:30 PM
 */

namespace App\Repositories\Feedback;


use App\Exam;
use App\Student;

class AccessKeyRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new AccessKeyRepository;
        $this->exam = Exam::all()->random();
        $this->student = Student::all()->random();
    }

    public function testGetAccessKeyForStudent()
    {
        $this->markTestIncomplete();
//        $key = AccessKey::onExam($examId)->where('student_id', $studentId)->first();
//        return $key->getKey();
    }


    public function testGetAccessKeysForExam()
    {
        $this->markTestIncomplete();
//        return AccessKey::onExam($examId)->get();
    }


    public function testCreateAccessKey()
    {
        $result = $this->object->createAccessKey(1,1);
        var_dump($result);
$this->assertNotEmpty($result);
//        $this->markTestIncomplete();
//        $accessKey = $this->generateNewKey();
//        if($accessKey)
//        {
//            $k = new AccessKey();
//            $k->setKey($accessKey);
//            $k->setExamId($examId);
//            $k->setStudentId($studentId);
//            $k->save();
//
//            if($k)
//            {
//                return $k->getKey();
//            }
//        }
    }



    public function testRetrieveFeedback()
    {
        $this->markTestIncomplete();
//        $accessKey
//        $this->validateKey($accessKey);
//        if(!empty($this->validKey))
//        {
//            return $this->loadFeedback();
//        }
    }

    public function testRemoveAccessKey()
    {
$this->markTestIncomplete();
    }

}
