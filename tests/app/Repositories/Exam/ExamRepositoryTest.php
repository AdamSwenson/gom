<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 2:56 PM
 */

namespace App\Repositories\Exam;
//use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\Exam;
use App\Repositories\Element\ElementAssignmentRepository;
use App\Repositories\Question\QuestionAssignmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;


class ExamRepositoryTest extends \TestCase
{
//    use DatabaseTransactions;

    protected $object;

    /** @var array Tables which a deletion should cascade to cover */
    static public $tables_using_exam = [
        'access_keys',
        'element_assignments',
        'exam_kumi',
        'grading_times',
        'question_assignments'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->object = new ExamRepository;
    }

    public function tearDown()
    {
//        if(count($this->toDelete) >0 )
//        {
//            Exam::destroy($this->toDelete);
//        }
    }

    public function prepareDatabase()
    {
//        parent::prepareDatabase();
        //random exam
        $this->exam = Exam::all()->random();
    }

    /**
     * Helper method to check that an exam deletion properly cascades.
     * NB, This doesn't check questionScores or elementScores which should
     * have rows deleted via cascade even though they do not have an exam_id field.
     *
     * @param $examId
     */
    public function checkThatExamRemovedFromAllTables($examId)
    {
        foreach(self::$tables_using_exam as $table)
        {
            $this->assertDatabaseMissing($table, ['exam_id' => $examId]);
        }
    }
#----------------------------------------------- delete exam
    /**
     * @test
     */
    public function testDelete_exam_from_exam_object()
    {
        //prep
        $exam = factory(Exam::class)->create();
        $eid = $exam->id;
        $this->assertDatabaseHas('exams', ['id' => $eid]);

        //call
        $result = $this->object->delete_exam($exam);

        //check
        $this->assertTrue($result);
        $this->assertEmpty(Exam::find($eid));
        $this->assertDatabaseMissing('exams', ['id' => $eid]);
        $this->checkThatExamRemovedFromAllTables($eid);
    }
    /**
     * @test
     */
    public function testDelete_exam_from_exam_id()
    {
        //prep
        $exam = factory(Exam::class)->create();
        $eid = $exam->id;
        $this->assertDatabaseHas('exams', ['id' => $eid]);

        //call
        $result = $this->object->delete_exam($eid);

        //check
        $this->assertTrue( $result || $result === 1);
        $this->assertEmpty(Exam::find($eid));
        $this->assertDatabaseMissing('exams', ['id' => $eid]);
        $this->checkThatExamRemovedFromAllTables($eid);
    }


//    /**
//     * @test
//     * @expectedException \App\Exceptions\InputTypeException
//     */
//    public function delete_exam_throws_exception_if_id_is_a_string()
//    {
//        $this->object->delete_exam('catfish');
//    }
//
//    /**
//     * @test
//     * @expectedException \Exception
//     */
//    public function delete_exam_throws_exception_if_id_is_empty_string()
//    {
//        $this->object->delete_exam('');
//    }
//
//
//    /**
//     * @test
//     * @expectedException \Exception
//     */
//    public function delete_exam_throws_exception_if_id_does_not_match_existing_exam()
//    {
//        $this->object->delete_exam(23422222223);
//    }

#----------------------------------------------------- save exam
    public function testSave_new_exam()
    {
        #prep
        $examName = $this->faker->text(5);
        $term = $this->faker->text(5);
        $year = $this->faker->year();
        $classId = 4;

        $data = ['name' => $examName,
            'term' => $term,
            'year' => $year
        ];
        $db_count = DB::table('exams')->count();

        #call
        $result = $this->object->save_new_exam($year, $term, $examName, $classId);

        #check
        $this->assertInstanceOf('\App\Exam', $result);
        $this->assertTrue($db_count < DB::table('exams')->count());
        $this->assertDatabaseHas('exams', $data);
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
        #prep
        $exam = factory(Exam::class)->create();
        $eid = $exam->getId();

        #call
        $result = $this->object->load_exam($eid);

        #check
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


#----------------------------------------------------------------- clone

    public function testClone_exam()
    {
        #prep
        //prepare source exam and database
        $exam = factory(Exam::class)->create();
        $examToCloneId = $exam->id;
        $questionAssignDao = new QuestionAssignmentRepository();
        $elementAssignDao = new ElementAssignmentRepository();

        $questionsToClone = $questionAssignDao->load_all_for_exam($examToCloneId);
        $elementsToClone = $elementAssignDao->load_by_exam($examToCloneId);

        #call
        $newExam = $this->object->clone_exam($examToCloneId);

        #check
        //make sure made new exam with expected naming scheme
        $clonedExam = Exam::where('id', $examToCloneId)->first();
        $expectedName = 'Clone of "' . $clonedExam->name . '"';
        $this->assertEquals($expectedName, $newExam->name, "new exam has expected name");
        //make sure other exam properties copied
        $this->assertEquals($clonedExam->term, $newExam->term, "term properly copied");
        $this->assertEquals($clonedExam->year, $newExam->year, "year properly copied");

        //make sure questions were copied
        foreach($questionsToClone as $qa)
        {
            $this->assertDatabaseHas('question_assignments',
                                 [
                                     'exam_id' => $newExam->id,
                                     'question_id' => $qa->question_id,
                                     'question_number' => $qa->question_number
                                 ]);
        }

        foreach($elementsToClone as $ea)
        {
            $this->assertDatabaseHas('element_assignments',
                                 [
                                     'exam_id' => $newExam->id,
                                     'question_id' => $ea->question_id,
                                     'element_id' => $ea->element_id,
                                     'subtask' => $ea->subtask
                                 ]);
        }

    }



#-------------------------------------------------------------- load all
    public function testLoad_all_exams()
    {
        $this->prepareDatabase();
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
        $this->prepareDatabase();

        $ex = Exam::all()->random(1);
        $ex->locked = 0;
        $ex->update();
        $this->assertInstanceOf('\App\Exam', $ex);
     //   $knownUnlocked = $ex->getId();

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
        $this->prepareDatabase();

        $ex = Exam::all()->random(1);
        $ex->locked = 0;
        $ex->update();
        $this->assertInstanceOf('\App\Exam', $ex);
        $knownUnlocked = $ex->getId();

        $result = $this->object->lock_exam($knownUnlocked);
        $this->assertInstanceOf('\App\Exam', $result, "returns exam");
        $this->assertDatabaseHas('exams', ['id' => $knownUnlocked, 'locked' => 1]);
//        $check = Exam::find($knownUnlocked);
//        $this->assertEquals(1, $check->locked);
    }


    public function testUnlock_exam()
    {
        $this->prepareDatabase();
        $exam = Exam::all()->random(1);
        //Ensure that we have a locked exam to unlock
        $toUnlock = $exam;
        $eid = $toUnlock->id;
        $toUnlock->locked = 1;
        $toUnlock->save();

//        $check = Exam::find($eid);
//        $this->assertEquals(1, $check->locked);

        //unlock and test
        $result = $this->object->unlock_exam($eid);
        $this->assertInstanceOf('\App\Exam', $result, "returns exam");
        $this->assertDatabaseHas('exams', ['id' => $eid, 'locked' => 0]);
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
