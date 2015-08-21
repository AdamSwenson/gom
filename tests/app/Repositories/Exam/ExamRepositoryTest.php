<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 2:56 PM
 */

namespace App\Repositories\Exam;
use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\Exam;
use Illuminate\Support\Facades\DB;


class ExamRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ExamRepository;

        //random exam
        $this->exam = Exam::all()->random();

        //ensure at least one exam is locked and released
//        $this->locked = Exam::find($this->faker->randomNumber(1));
        $this->locked = Exam::all()->random();
        $this->locked->locked = 1;
        $this->locked->released = 1;
        $this->locked->save();
    }

    public function tearDown()
    {
//        if(count($this->toDelete) >0 )
//        {
//            Exam::destroy($this->toDelete);
//        }
    }

#----------------------------------------------- delete exam
    /**
     * TODO Test that on delete this cascades to other things like question scores
     */
    public function testDelete_exam()
    {
        $eid = $this->exam->id;
        $this->object->delete_exam($eid);
        $this->assertEmpty(Exam::find($eid));
    }

//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testDelete_examExceptionIdWrongType()
//    {
//        $this->object->delete_exam('catfish');
//    }
//
//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testDelete_examExceptionIdEmpty()
//    {
//        $this->object->delete_exam('');
//    }
//
//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testDelete_examExceptionIdNotMatchExam()
//    {
//        $this->object->delete_exam(23422222223);
//    }

#----------------------------------------------------- save exam
    public function testSave_new_exam()
    {
        $examName = $this->faker->text(5);
        $term = $this->faker->text(5);
        $year = $this->faker->year();
        $classId = 4;

        $data = ['name' => $examName,
            'term' => $term,
            'year' => $year
        ];
        $db_count = DB::table('exams')->count();

        $result = $this->object->save_new_exam($year, $term, $examName, $classId);

        $this->assertInstanceOf('\App\Exam', $result);

        $this->assertTrue($db_count < DB::table('exams')->count());
        $this->seeInDatabase('exams', $data);

//        $exam = Exam::find($result->id);
//        $this->assertEquals($examName, $exam->name);
//        $this->assertEquals($term, $exam->term);
//        $this->assertEquals($year, $exam->year);
//        $this->assertEquals(0, $exam->locked);
//        $this->assertEquals(0, $exam->released);
//        $this->assertEquals(self::$userid, $exam->user_id);
    }

//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testSave_new_examExceptionYearWrongType()
//    {
//        $examName = $this->faker->word();
//        $term = $this->faker->word();
//        $year = 'taco';
//        $classId = 4;
//        $this->object->save_new_exam($examName, $year, $term, $classId);
//    }
//
//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testSave_new_examExceptionYearTooLong()
//    {
//        $examName = $this->faker->word();
//        $term = $this->faker->word();
//        $year = 20134;
//        $classId = 4;
//        $this->object->save_new_exam($examName, $year, $term, $classId);
//    }
//
//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testSave_new_examExceptionNameWrongType()
//    {
//        $examName = array('cat' => 'fish');
//        $term = $this->faker->word();
//        $year = $this->faker->year();
//        $classId = 4;
//        $this->object->save_new_exam($examName, $year, $term, $classId);
//    }
//
//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testSave_new_examExceptionNameTooLong()
//    {
//        $chars = Exam::MAX_NAME_LENGTH + 5;
//        $examName = $this->faker->text($chars);
//        $term = $this->faker->word();
//        $year = $this->faker->year();
//        $classId = 4;
//        $this->object->save_new_exam($examName, $year, $term, $classId);
//    }
//
//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testSave_new_examExceptionTermWrongType()
//    {
//        $examName = $this->faker->word();
//        $term = array('cat' => 'fish');;
//        $year = $this->faker->year();
//        $classId = 4;
//        $this->object->save_new_exam($examName, $year, $term, $classId);
//    }
//
//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testSave_new_examExceptionTermTooLong()
//    {
//        $chars = Exam::MAX_TERM_LENGTH + 5;
//        $examName = $this->faker->word();
//        $term = $this->faker->text($chars);
//        $year = 'taco';
//        $classId = 4;
//        $this->object->save_new_exam($examName, $year, $term, $classId);
//    }

#--------------------------------------------------------- load exam

    public function testLoad_exam()
    {
        $exam = Exam::all()->random();
        $eid = $exam->getId();
        $result = $this->object->load_exam($eid);
        $this->assertInstanceOf('\App\Exam', $result);
        $this->assertEquals($eid, $result->getId());
    }

    /**
     * @expectedException \Exception
     */
    public function testLoad_examExceptionIdNotFound()
    {
        $this->object->load_exam(234349839976478);
    }

//    /**
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function testLoad_examExceptionIdWrongType()
//    {
//        $this->object->load_exam('catfish');
//    }

#-------------------------------------------------------------- load all
    public function testLoad_all_exams()
    {
        $result = $this->object->load_all_exams();
        $this->assertNotEmpty($result);
        foreach($result as $e)
        {
            $this->assertInstanceOf('\App\Exam', $e);
        }
    }

    public function testLoad_exams_by_class()
    {
        //TODO Implement test
//        $class = Kumi::random();
//        $result = $this->object->getAllExams();
//        $this->assertNotEmpty($result);
//        foreach($result as $e)
//        {
//            $this->assertInstanceOf('\App\Exam', $e);
//        }
    }


    public function testLoad_unlocked_exams()
    {
        $result = $this->object->load_unlocked_exams();
//        $this->assertNotEmpty($result);
        foreach($result as $e)
        {
            $this->assertInstanceOf('\App\Exam', $e);
            $this->assertEquals(0, $e->locked);
        }
    }

    public function testLock_exam()
    {
        $ex = Exam::all()->random(1);
        $ex->locked = 0;
        $ex->update();
        $this->assertInstanceOf('\App\Exam', $ex);
        $knownUnlocked = $ex->getId();

        $result = $this->object->lock_exam($knownUnlocked);
        $this->assertInstanceOf('\App\Exam', $result, "returns exam");
        $this->seeInDatabase('exams', ['id' => $knownUnlocked, 'locked' => 1]);
//        $check = Exam::find($knownUnlocked);
//        $this->assertEquals(1, $check->locked);
    }


    public function testUnlock_exam()
    {
        //Ensure that we have a locked exam to unlock
        $toUnlock = $this->exam;
        $eid = $toUnlock->id;
        $toUnlock->locked = 1;
        $toUnlock->save();

//        $check = Exam::find($eid);
//        $this->assertEquals(1, $check->locked);

        //unlock and test
        $result = $this->object->unlock_exam($eid);
        $this->assertInstanceOf('\App\Exam', $result, "returns exam");
        $this->seeInDatabase('exams', ['id' => $eid, 'locked' => 0]);
        $this->assertEquals(0, $result->locked);
    }

//
//    public function testMark_exam_released($examId)
//    {
////        $exam = $this->load_exam($examId);
////        $exam->setReleased(1);
////        $exam->save();
//    }
//
//    public function testUnmark_exam_released($examId)
//    {}






}
