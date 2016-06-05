<?php


use App\Exam;
use App\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase
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



//
//    public function setupExamWithStudents(){
//        $this->kumi = factory(Kumi::class)->create();
//        $this->exam = factory(Exam::class)->create();
//        $this->kumi->exams()->attach($this->exam);
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
