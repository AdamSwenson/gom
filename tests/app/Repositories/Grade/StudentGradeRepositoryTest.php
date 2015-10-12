<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/9/15
 * Time: 4:31 PM
 */

namespace App\Repositories\Grade;


use App\Exam;
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
    protected $questionAssignments;
    protected $questions;

    public function setUp()
    {
        parent::setUp();
$faker = \Faker\Factory::create();

        //fuck you laravel for making me do this the long fucking way
        $this->exam = new Exam();
        $this->exam->term = $faker->word;
        $this->exam->year = $faker->year;
        $this->exam->save();

        $this->student = new Student();
        $this->student->last_name = \Faker\Factory::create()->lastName;
        $this->student->first_name = \Faker\Factory::create()->firstName;
        $this->student->save();

        $this->questions = [];
        $this->questionAssignments = [];
        for($i=1; $i<=self::$numQuestions; $i++)
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

        $this->object = new StudentGradeRepository();
    }


    /**
     * @test
     */
    public function calculateTotalScoreForStudent()
    {
        //prep
        $scores = [];
        for($i=0; $i<count($this->questionAssignments); $i++)
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
        $this->assertEquals($expectedTotal, $result);
    }
}
