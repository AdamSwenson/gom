<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/1/17
 * Time: 7:37 PM
 */

namespace Tests\Browser;


use Faker\Factory;
use Tests\DuskTestCase;

class BrowserTestBase extends DuskTestCase
{
    public $faker;

    public function __construct()
    {
    $this->faker = Factory::create();
    }

}