<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/27/17
 * Time: 4:59 PM
 */

namespace App\Repositories\Item;


use App\Exam;
use App\Item;
use App\Kumi;
use App\Models\NewGom\ItemScore;
use App\Student;
use Faker\Factory;

class ItemScoreStatisticsRepositoryTest extends \TestCase
{

    protected $object;
    public $item;
    public $exam1;
    public $exam2;
    public $scores;
    public $students = [];
    public $kumis = [];

    const NUM_SCORES = 10;
    const EXPECTED_MEDIAN = 5;

    public function setUp()
    {
        parent::setUp();
        $this->item = factory(Item::class)->create();
        $this->exam1 = factory(Exam::class)->create();
        $this->exam2 = factory(Exam::class)->create();

        $this->makeScores($this->exam1);
        $this->makeScores($this->exam2, 11);

        $this->object = new ItemScoreStatisticsRepository;
    }

//
//    /**
//     * THIS DUPLICATES THE SEEDER. SHOULD NOT USE THIS.
//     * Creates test kumis
//     * if overlapping is false, then there are no students
//     * in the intersection of the kumis
//     * @param $numberStudentsInKumi
//     * @param int $numberKumis
//     */
//    public function makeKumis($numberStudentsInKumi, $numberKumis=2, $overlapping=false){
//        $this->kumis = factory(Kumi::class, $numberKumis)->create();
//
//        foreach($this->kumis as $kumi){
//            $students = factory(Student::class, $numberStudentsInKumi)->create();
//            foreach($students as $student){
//                $this->students[] = $student;
//                $student->kumis()->attach($kumi);
//            }
//        }
//
//    }
//
//    /** @test */
//    public function makeKumisBehavesAsExpected(){
//        $numKumis = Factory::create()->randomNumber(1);
//        $numberStudentsInKumi = Factory::create()->randomNumber(1);
//
//        $this->makeKumis($numberStudentsInKumi, $numKumis);
//
//        //check
//        $this->assertEquals($numKumis, sizeof($this->kumis));
//        $this->assertEquals($numberStudentsInKumi * $numKumis, sizeof($this->students));
//
//    }

    /**
     * Creates test data
     * The data will have two kumi for the exam
     */
    public function makeScores( $exam, $startScore = 1 )
    {
        $k1 = factory(Kumi::class)->create();
        $k2 = factory(Kumi::class)->create();

        for ( $i = $startScore; $i < $startScore + self::NUM_SCORES; $i++ ) {
            $student = factory(Student::class)->create();
            $kumi = ($i % 2 == 0) ? $k1 : $k2;
            $student->kumis()->attach($kumi);
            $score = new ItemScore();
            $score->exam()->associate($exam);
            $score->item()->associate($this->item);
            $score->student()->associate($student);
            $score->score = $i;
            $score->save();
            $this->scores[] = $score;
        }
    }

//----------------------- Descriptive stats
    /** @test */
    public function getDescriptiveStatsForAllItemScores()
    {
        $result = $this->object->getDescriptiveStats($this->item);
        //check that has expected keys
        $this->assertEquals(10.5, $result['mean']);
        $this->assertEquals(5.77, $result['standardDeviation'], '', 0.2);
        $this->assertEquals(1, $result['minScore']);
        $this->assertEquals(20, $result['maxScore']);
        $this->assertEquals(20, $result['numberAnswers']);
    }

    /** @test */
    public function getDescriptiveStatsByExam()
    {
        $result = $this->object->getDescriptiveStats($this->item, $this->exam1);
        //check that has expected keys
        $this->assertEquals(5.5, $result['mean']);
        $this->assertEquals(2.87, $result['standardDeviation'], '', 0.2);
        $this->assertEquals(1, $result['minScore']);
        $this->assertEquals(10, $result['maxScore']);
        $this->assertEquals(10, $result['numberAnswers']);
    }


    /** @test */
    public function getDescriptiveStatsByKumiForItem()
    {
        $result = $this->object->getDescriptiveStatsByKumiForItem($this->item);
        //check that has expected keys
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals(5.5, $result->mean);
        $this->assertEquals(2.87, $result->standardDeviation, '', 0.2);
        $this->assertEquals(1, $result->minScore);
        $this->assertEquals(10, $result->maxScore);
        $this->assertEquals(10, $result->numberAnswers);
        $this->assertEquals(5, $result->median);
    }




// ---------------------------- Medians

    /** @test */
    public function getMedianForAllItemScores()
    {
        $result = $this->object->getMedian($this->item);
        $this->assertEquals(10.5, $result);
    }

    /** @test */
    public function getMedianForItemScoresByExam()
    {
        $result = $this->object->getMedian($this->item, $this->exam1);
        $this->assertEquals(5.5, $result);
    }

// ------------------------- Quartiles

    /** @test */
    public function getQuartilesForAllItemScores()
    {
        $result = $this->object->getQuartiles($this->item);

        //check
        $this->assertTrue(array_has($result, ['quartile1', 'quartile3']));

        $this->assertEquals(6, $result['quartile1']);
        $this->assertEquals(16, $result['quartile3']);
    }

    /** @test */
    public function getQuartilesForItemScoresOnSpecifiedExam()
    {
        $result = $this->object->getQuartiles($this->item, $this->exam1);
        //check that has expected keys
        $this->assertTrue(array_has($result, ['quartile1', 'quartile3']));

        $this->assertEquals(4, $result['quartile1']);
        $this->assertEquals(9, $result['quartile3']);

    }


    public function getQuartilesForItemScoresInKumis()
    {

    }
}
