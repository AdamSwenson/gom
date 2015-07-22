<?php
use Auth;
class TestCase extends Illuminate\Foundation\Testing\TestCase
{
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
        //        $this->user = \UserQuery::create()->filterById(self::$userid)->findOneOrCreate();
        $this->faker = \Faker\Factory::create();

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        Auth::loginUsingId(self::$userid);

        return $app;
    }
}
