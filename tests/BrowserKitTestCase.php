<?php


use App\Element;
use App\ElementAssignment;
use App\Exam;
use App\Kumi;
use App\Question;
use App\QuestionAssignment;
use App\Student;
use App\User;
use Tests\DuskTestCase;

class BrowserKitTestCase extends Laravel\BrowserKitTesting\TestCase
{

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /** @var  \Faker\Factory */
    public $faker;


    public static $userid = 1;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // Temporarily increase memory limit
        ini_set('memory_limit', '1024M');

        $this->faker = \Faker\Factory::create();

        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        \Auth::loginUsingId(self::$userid);

        return $app;
    }

    /**
     * Creates a mock object and overrides the service container
     * @param $class
     * @return \Mockery\MockInterface
     */
    public function createMock($class)
    {
        $mock = \Mockery::mock($class);
        $this->registerMock($class, $mock);

        return $mock;
    }

    /**
     * Registers the mock object for the current instance
     * @param $className
     * @param $mockObject
     */
    public function registerMock($className, $mockObject)
    {
        $this->app->instance($className, $mockObject);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    /**
     * Makes a question assignment with the specified items.
     * Returns the questionAssignment model
     *
     * @param $exam
     * @param $question
     * @param $questionNumber
     * @return QuestionAssignment
     */
    public function makeQuestionAssignment($exam, $question, $questionNumber)
    {
        $qa = new QuestionAssignment();
        $qa->exam_id = $exam->id;
        $qa->question_id = $question->id;
        $qa->question_number = $questionNumber;
        $qa->save();

        return $qa;
    }

    /**
     * Creates an exam1 with the specified number of questions assigned.
     * Returns the fixture as an array containing:
     *      'questionIds' => $questionIds,
     *      'questions'   => $questions,
     *      'examId'      => $exam1->id,
     *      'exam1'        => $exam1,
     *
     * @param $numberQuestions
     * @return array Keys: examId, questionIds (array)
     */
    public function makeExamWAssignedQuestions($numberQuestions)
    {
        $questionIds = [];
        $questions = [];
        $exam = factory(Exam::class)->create();
        for ( $i = 1; $i <= $numberQuestions; $i++ )
        {
            $question = factory(Question::class)->create();
            $question->setQuestionNumber($exam->id, $i);
            $questions[] = $question;
            $questionIds[] = $question->id;
        }

        return [
            'questionIds' => $questionIds,
            'questions'   => $questions,
            'examId'      => $exam->id,
            'exam1'        => $exam,
        ];
    }

    /**
     * Creates an exam1 with one kumi, populated with students
     * Returns the fixture as an array containing:
     *      'exam1'       => $exam1,
     *      'kumi'       => $kumi,
     *      'students'   => $students,
     *      'studentIds' => $studentIds,
     *
     * Also sets the following properties of the test case object:
     *      $this->exam1 = $exam1;
     *      $this->kumi = $kumi;
     *      $this->students = $students;
     *
     * @param bool $exam
     * @param bool $kumi
     * @param int $numberStudents
     * @return array
     */
    public function setupExamWithStudents($exam = false, $kumi = false, $numberStudents = 5)
    {
        $studentIds = [];

        if ( ! $exam )
        {
            $exam = factory(Exam::class)->create();
        }
        if ( ! $kumi )
        {
            $kumi = factory(Kumi::class)->create();
            //add the kumi to the exam1 if not associated
            $kumi->exams()->attach($exam);
        }
        
        //create students and put in expected order
        $students = factory(Student::class, $numberStudents)->create();
        $students = $students->sortBy('last_name');

        foreach ( $students as $item )
        {
            $kumi->students()->attach($item);
            $studentIds[] = $item->id;
        }
        $kumi->push();

        $this->exam = $exam;
        $this->kumi = $kumi;
        $this->students = $students;

        return [
            'exam1'       => $exam,
            'kumi'       => $kumi,
            'students'   => $students,
            'studentIds' => $studentIds,
        ];
    }


    /**
     * Returns the fixture as an array containing:
     *      'question' => $question,
     *      'elements' => $elements,
     *      'elementIds' => $elementIds Array of integers
     *      'questionNumber' => $questionNumber
     *      'elementAssignments' => $elementAssignments,
     *      'questionNumber'     => $questionNumber,
     *
     * @param $numberElements
     * @param bool $exam
     * @param bool $question
     * @param bool $questionNumber
     * @return array
     */
    public function makeElementAssignmentsForQuestion($numberElements, $exam = false, $question = false, $questionNumber = false)
    {
        $elements = [];
        $elementIds = [];
        $elementAssignments = [];

        if ( ! $exam )
        {
            $exam = factory(Exam::class)->create();
        }
        if ( ! $question )
        {
            $question = factory(Question::class)->create();
        }
        if ( ! $questionNumber )
        {
            $questionNumber = Faker\Factory::create()->randomDigitNotNull;
            $this->makeQuestionAssignment($exam, $question, $questionNumber);

        }
        
        for ( $i = 1; $i <= $numberElements; $i++ )
        {
            $e = factory(Element::class)->create();
            $ea = new ElementAssignment();
            $ea->exam()->associate($exam);
            $ea->question()->associate($question);
            $ea->element()->associate($e);
            $ea->subtask = $i;
            $ea->save();

            $elements[] = $e;
            $elementIds[] = $e->id;
            $elementAssignments[] = $ea;
        }

        return [
            'exam1'               => $exam,
            'question'           => $question,
            'elements'           => $elements,
            'elementIds'         => $elementIds,
            'elementAssignments' => $elementAssignments,
            'questionNumber'     => $questionNumber,
        ];
    }


//
//    public function setupExamWithStudents(){
//        $this->kumi = factory(Kumi::class)->create();
//        $this->exam1 = factory(Exam::class)->create();
//        $this->kumi->exams()->attach($this->exam1);
//        //create students and put in expected order
//        $this->students = factory(Student::class, 5)->create();
//        $this->students = $this->students->sortBy('last_name');
//        $this->studentIds = [];
//        foreach ( $dthis->students as $item )
//        {
//            $this->kumi->students()->attach($item);
//            $this->studentIds[] = $item->id;
//        }
//        $this->kumi->push();
//    }


//    protected $nestedViewData = array();
//
//    public function registerNestedView($view)
//    {
//        View::composer($view, function($view){
//            $this->nestedViewsData[$view->getName()] = $view->getData();
//        });
//    }
//
//    /**
//     * Assert that the given view has a given piece of bound data.
//     *
//     * @param  string|array  $key
//     * @param  mixed  $value
//     * @return void
//     */
//    public function assertNestedViewHas($view, $key, $value = null)
//    {
//        if (is_array($key)) return $this->assertNestedViewHasAll($view, $key);
//
//        if ( ! isset($this->nestedViewsData[$view]))
//        {
//            return $this->assertTrue(false, 'The view was not called.');
//        }
//
//        $data = $this->nestedViewsData[$view];
//
//        if (is_null($value))
//        {
//            $this->assertArrayHasKey($key, $data);
//        }
//        else
//        {
//            if(isset($data[$key]))
//                $this->assertEquals($value, $data[$key]);
//            else
//                return $this->assertTrue(false, 'The View has no bound data with this key.');
//        }
//    }
//
//    /**
//     * Assert that the view has a given list of bound data.
//     *
//     * @param  array  $bindings
//     * @return void
//     */
//    public function assertNestedViewHasAll($view, array $bindings)
//    {
//        foreach ($bindings as $key => $value)
//        {
//            if (is_int($key))
//            {
//                $this->assertNestedViewHas($view, $value);
//            }
//            else
//            {
//                $this->assertNestedViewHas($view, $key, $value);
//            }
//        }
//    }
//
//    public function assertNestedView($view)
//    {
//        $this->assertArrayHasKey($view, $this->nestedViewsData);
//    }
}
