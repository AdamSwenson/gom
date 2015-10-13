<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/9/15
 * Time: 4:31 PM
 */

namespace App\Repositories\Grade;


use App\Exam;
use App\GradeAssignment;
use App\Question;
use App\QuestionAssignment;
use App\QuestionScore;
use App\Repositories\Grade\StudentGradeRepository;
use App\Student;

use Faker\Factory;
use TestCase;

class StudentGradeRepositoryTest extends TestCase
{

    protected $object;
    protected $student;
    protected $exam;

    public static $examId = 10001;
    public static $studentId = 10002;
    public static $numQuestions = 5;

    /** @var float When creating grade assignments to test, the amount between each grade */
    public static $intervalBetweenCutoffs = 5.5;

    protected $questionAssignments;
    protected $questions;

    public function setUp()
    {
        parent::setUp();

        $this->makeCleanEntries();
        $this->object = new StudentGradeRepository();
    }


    public function makeCleanEntries()
    {
        //fuck you laravel for making me do this the long fucking way
        $this->exam = new Exam();
        $this->exam->term = \Faker\Factory::create()->word;
        $this->exam->year = \Faker\Factory::create()->year;
        $this->exam->save();

        $this->student = new Student();
        $this->student->last_name = \Faker\Factory::create()->lastName;
        $this->student->first_name = \Faker\Factory::create()->firstName;
        $this->student->save();

        $this->questions = [];
        $this->questionAssignments = [];
        for ($i = 1; $i <= self::$numQuestions; $i++)
        {
            $q = new Question();
            $q->save();
            $this->questions[] = $q;

            $qa = new QuestionAssignment();
            $qa->exam_id = $this->exam->id;
            $qa->question_id = $q->id;
            $qa->question_number = $i;
            $qa->save();

            $this->questionAssignments[] = $qa;
        }
    }


    /**
     * @test
     */
    public function calculateTotalScoreForStudent()
    {
        //prep
        $scores = [];
        for ($i = 0; $i < count($this->questionAssignments); $i++)
        {
            $score = Factory::create()->randomFloat(2, 0, 10);
            $scores[] = $score;
            $q = new QuestionScore();
            $q->question_assignment_id = $this->questionAssignments[$i]->id;
            $q->student_id = $this->student->id;
            $q->score = $score;
            $q->save();

        }
        $expectedTotal = array_sum($scores);

        //call
        $result = $this->object->calculateTotalScoreForStudent($this->exam, $this->student);

        //check
        $this->assertEquals($expectedTotal, $result, "Result sum matches expected sum");
    }


    /**
     * @test
     */
    public function determineGrade()
    {
        //prep
        //Make a known set of grade cutoffs and replace the set loaded from the db
        $testAssignments = [];

        $minScore = 0;
        foreach (array_reverse(GradeFactory::$grades) as $g)
        {
            //Build a new grade assignment and push into array (w/o saving to db)
            $ga = new GradeAssignment();
            $ga->setMinScore($minScore);
            $ga->setGrade(GradeFactory::loadByGradeId($g['grade_id']));
            $testAssignments[] = $ga;

            //increment the minScore
            $minScore += self::$intervalBetweenCutoffs;
        }

        /*
         * We built the testAssignments from F up to A. But the object will be expecting to have an array of
         * grades in descending order. So, we reverse the test assignments to mirror the actual array that gets loaded.
         */
        $descTestAssignments = array_reverse($testAssignments);

        //Replace the array of assignments which loads from db with the test array
        $this->object->gradeAssignments = $descTestAssignments;

        //Iterate through from lowest to highest and make sure get expected grades
        for($i=0; $i<count($testAssignments); $i++)
        {
            $testScore = ($i * self::$intervalBetweenCutoffs) + 0.1;
            $result = $this->object->determineGrade($testScore);

            //check
            $this->assertInstanceOf('App\Grade', $result, "Returns a grade model object");
            $this->assertEquals($testAssignments[$i]->getGrade(), $result, "Result is the expected grade model object");
        }
    }



    /**
     * @test
     */
    public function makeSureDetermineGradeStillWorksIfNotAllPossibleGradesAreUsed()
    {
        //prep
        //Make a known set of grade cutoffs and replace the set loaded from the db
        $testAssignments = [];

        $minScore = 0;
        foreach (array_reverse(GradeFactory::$grades) as $g)
        {
            //Build a new grade assignment and push into array (w/o saving to db)
            $ga = new GradeAssignment();
            $ga->setMinScore($minScore);
            $ga->setGrade(GradeFactory::loadByGradeId($g['grade_id']));
            $testAssignments[] = $ga;

            //increment the minScore
            $minScore += self::$intervalBetweenCutoffs;
        }

        //Unset a few of the grades
        unset($testAssignments[3]);
        unset($testAssignments[7]);
        unset($testAssignments[10]);
        //make new array so indexes are in proper order
        $testAssignments2 = [];
        foreach($testAssignments as $a)
        {
            $testAssignments2[] = $a;
        }

        /*
        * We built the testAssignments from F up to A. But the object will be expecting to have an array of
        * grades in descending order. So, we reverse the test assignments to mirror the actual array that gets loaded.
        */
        $descTestAssignments = array_reverse($testAssignments2);

        //Replace the array of assignments which loads from db with the test array
        $this->object->gradeAssignments = $descTestAssignments;

        //Iterate through in ascending order and make sure get expected grades
        for($i=0; $i<count($testAssignments2); $i++)
        {
            //call
            $testScore = $testAssignments2[$i]->getMinScore() + 0.1;
            $result = $this->object->determineGrade($testScore);

//            echo $testAssignments2[$i]->getGrade()->getDisplayValue() . ' ' . $testAssignments2[$i]->getMinScore() . '  ' . $testScore . ' ||||| ';

            //check
            $this->assertInstanceOf('App\Grade', $result, "Returns a grade model object");
            $this->assertEquals($testAssignments2[$i]->getGrade(), $result, "Result is the expected grade model object");
        }
    }
}
