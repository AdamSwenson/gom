<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 12:59 PM
 */

namespace HTTP\Controllers;


use App\Http\Controllers\GradingController;

class GradingControllerTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new GradingController();
    }

}
