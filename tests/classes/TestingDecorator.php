<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 3:05 PM
 */

namespace classes;


class TestingDecorator
{
    /** @var $response The response to return  */
    public $response;

    /** @var  $called The name of the method called */
    public $called;

    /** @var $arguments array Array of arguments given to method  */
    public $arguments = array();

    public function __construct($object) {
        $this->object = $object;
    }

    public function __call($name, $arguments)
    {
        $this->called = $name;
        $this->arguments = $arguments;
        return call_user_func_array(array($this->object, $name), $arguments);
    }





}