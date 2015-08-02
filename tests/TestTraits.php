<?php

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 10:32 AM
 */
trait TestTraits
{
    /**
     * Creates a mock object and overrides the service container
     * @param $class
     * @return \Mockery\MockInterface
     */
    public function makeMock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

}