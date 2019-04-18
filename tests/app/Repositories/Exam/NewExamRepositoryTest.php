<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 12/17/18
 * Time: 10:32 AM
 */

namespace App\Repositories\Exam;


use App\Exam;

class NewExamRepositoryTest extends \TestCase
{

    protected $object;

//    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->object = new NewExamRepository;
    }

    public function testGetEmptyExams()
    {

        $exams = $this->object->getEmptyExams();
        //todo This needs to start with a clean db state so know whether there are any empty exams
        if ( sizeof($exams) > 0 ) {
            foreach ( $exams as $exam ) {
                $this->assertNull($exam->name);
                $this->assertNull($exam->public_name);
                $this->assertNull($exam->year);
                $this->assertNull($exam->term);
                $this->assertNull($exam->description);

                //check relationships
                //due to the query logic, our exams with have assignments_count etc
                $this->assertEquals(0, $exam->assignments_count);
            }
        }

    }

    public function testMakeNewExam()
    {
        $expectedKumiName = 'Group1';

        $exam = $this->object->makeNewExam();
        //check that it is the right model
        $this->assertInstanceOf(Exam::class, $exam, "returns correct model");

        //check it has exactly 1 kumi
        $this->assertEquals(1, sizeof($exam->kumis()->get()), "has 1 kumi");

        //check that it has the expected kumi name
        $this->assertEquals($expectedKumiName, $exam->kumis()->first()->name, "has correct kumi name");
    }

}
