<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/13/15
 * Time: 12:31 PM
 */

namespace App\Repositories\Score;

use App\ElementAssignment;
use App\ElementScore;
use App\Exam;
use App\QuestionAssignment;
use App\QuestionScore;

class ScoreStatisticsRepositoryTest extends \TestCase
{

    protected $object;

    public static $examId = 1;
    static public $elementAssignmentId = 1;
    static public $questionAssignmentId = 1;

    protected $exam;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ScoreStatisticsRepository;
        $this->exam = Exam::find(self::$examId);
    }


    public function testLoadStats()
    {
        $this->object->loadStats($this->exam);

        //check
        $this->assertAttributeNotEmpty('questionAssignmentMeans', $this->object, 'question assignment means loaded');
        $this->assertAttributeNotEmpty('elementAssignmentMeans', $this->object, 'element assignment means loaded');

        //Check values of element scores
        foreach(ElementAssignment::where('exam_id', $this->exam) as $ea)
        {
            $scores = [];
            foreach(ElementScore::where('element_assignment_id', $ea->id)->get() as $es)
            {
                $scores[] = $es->score;
            }
            $expectedMean = array_sum($scores) / count($scores);

            $this->assertEquals($expectedMean, $this->object->elementAssignmentMeans[$ea->id], 'expected mean found', 0.001);
        }

        //Check values of element scores
        foreach(QuestionAssignment::where('exam_id', $this->exam) as $ea)
        {
            $scores = [];
            foreach(QuestionScore::where('question_assignment_id', $ea->id)->get() as $es)
            {
                $scores[] = $es->score;
            }
            $expectedMean = array_sum($scores) / count($scores);

            $this->assertEquals($expectedMean, $this->object->questionAssignmentMeans[$ea->id], 'expected mean found', 0.001);
        }

    }


    /**
     * @test
     */
    public function getQuestionAssignmentMean()
    {
        $testId = 100;
        $testMean = 34.5;

        $test = [101 => 356, $testId => $testMean, 104 => 4.3];

        $this->object->questionAssignmentMeans = $test;

        //call
        $result = $this->object->getQuestionAssignmentMean($testId);
        $this->assertEquals($testMean, $result, "correct value returned");

        //null case
        $result = $this->object->getQuestionAssignmentMean(200);
        $this->assertEquals(null, $result, 'null returned when assignment id not a key');
    }


    /**
     * @test
     */
    public function getElementAssignmentMean()
    {
        $testId = 100;
        $testMean = 34.5;

        $test = [101 => 356, $testId => $testMean, 104 => 4.3];

        $this->object->elementAssignmentMeans = $test;

        //call
        $result = $this->object->getElementAssignmentMean($testId);
        $this->assertEquals($testMean, $result, "correct value returned for element assignment");

        //null case
        $result = $this->object->getElementAssignmentMean(200);
        $this->assertEquals(null, $result, 'null returned when assignment id not a key');
    }

//
//    /**
//     * @test
//     */
//    public function getStatsForElementAssignment()
//    {
//        //prep
//        $scores = [];
//        foreach(ElementScore::where('element_assignment_id', self::$elementAssignmentId)->get() as $es)
//        {
//            $scores[] = $es->score;
//        }
//        $expectedMean = array_sum($scores) / count($scores);
//
//        //call
//        $result = $this->object->getStatsForElementAssignment($this->exam, self::$elementAssignmentId, $returnValueOf=null);
//
//        //check
//        //Make sure internal array was populated and made into laravel collection
//        $this->assertAttributeNotEmpty('elementStats', $this->object, 'elementStats was populated');
//        $this->assertAttributeInstanceOf('Illuminate\Support\Collection', 'elementStats', $this->object, 'elementStats made into collection');
//
//        //Make sure returned collection as expected and with the correct mean
//        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
//        $this->assertEquals(self::$elementAssignmentId, $result[0]['elementAssignmentId'], 'array contains element assignment id');
//        $this->assertEquals($expectedMean, $result[0]['mean'], 'returns expected mean', 0.001);
//    }
//
//
//    /**
//     * @test
//     */
//    public function getStatsForElementAssignmentReturnValueOfMean()
//    {
//        //prep
//        $scores = [];
//        foreach(ElementScore::where('element_assignment_id', self::$elementAssignmentId)->get() as $es)
//        {
//            $scores[] = $es->score;
//        }
//        $expectedMean = array_sum($scores) / count($scores);
//
//        //call
//        $result = $this->object->getStatsForElementAssignment($this->exam, self::$elementAssignmentId, $returnValueOf='mean');
//
//        //check
//        //Make sure internal array was populated and made into laravel collection
//        $this->assertAttributeNotEmpty('elementStats', $this->object, 'elementStats was populated');
//        $this->assertAttributeInstanceOf('Illuminate\Support\Collection', 'elementStats', $this->object, 'elementStats made into collection');
//
//        //Make sure returned the value as expected and with the correct mean
//        $this->assertEquals($expectedMean, $result, 'returns expected mean', 0.001);
//    }
//
//    /**
//     * @test
//     */
//    public function getStatsForQuestionAssignment()
//    {
//        //prep
//        $scores = [];
//        foreach(QuestionScore::where('question_assignment_id', self::$questionAssignmentId)->get() as $es)
//        {
//            $scores[] = $es->score;
//        }
//        $expectedMean = array_sum($scores) / count($scores);
//
//        //call
//        $result = $this->object->getStatsForQuestionAssignment($this->exam, self::$questionAssignmentId, $returnValueOf=null);
//
//        //check
//        //Make sure internal array was populated and made into laravel collection
//        $this->assertAttributeNotEmpty('questionStats', $this->object, 'questionStats was populated');
//        $this->assertAttributeInstanceOf('Illuminate\Support\Collection', 'questionStats', $this->object, 'questionStats made into collection');
//
//        //Make sure returned collection as expected and with the correct mean
//        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
//        $this->assertEquals(self::$questionAssignmentId, $result[0]['questionAssignmentId'], 'array contains question assignment id');
//        $this->assertEquals($expectedMean, $result[0]['mean'], 'returns expected mean', 0.001);
//    }
//
//
//    /**
//     * @test
//     */
//    public function getStatsForQuestionAssignmentReturnsValueOfMean()
//    {
//        //prep
//        $scores = [];
//        foreach(QuestionScore::where('question_assignment_id', self::$questionAssignmentId)->get() as $es)
//        {
//            $scores[] = $es->score;
//        }
//        $expectedMean = array_sum($scores) / count($scores);
//
//        //call
//        $result = $this->object->getStatsForQuestionAssignment($this->exam, self::$questionAssignmentId, $returnValueOf=ScoreStatisticsRepository::STAT_MEAN);
//
//        //check
//        //Make sure internal array was populated and made into laravel collection
//        $this->assertAttributeNotEmpty('questionStats', $this->object, 'questionStats was populated');
//        $this->assertAttributeInstanceOf('Illuminate\Support\Collection', 'questionStats', $this->object, 'questionStats made into collection');
//
//        //Make sure returned collection as expected and with the correct mean
//        $this->assertEquals($expectedMean, $result, 'returns expected mean', 0.001);
//    }
//

}
