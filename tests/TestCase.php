<?php
use Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
//    use DatabaseTransactions;
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    public $faker;

    public static $userid = 1;
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // Temporarily increase memory limit to 256MB
        ini_set('memory_limit','256M');

        //        $this->user = \UserQuery::create()->filterById(self::$userid)->findOneOrCreate();
        $this->faker = \Faker\Factory::create();

        $app = require __DIR__.'/../bootstrap/app.php';

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
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    Mockery::close();
    }







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
