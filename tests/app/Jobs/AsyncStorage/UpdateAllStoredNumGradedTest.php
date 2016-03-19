<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/18/16
 * Time: 3:21 PM
 */

namespace App\Jobs\AsyncStorage;


class UpdateAllStoredNumGradedTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new UpdateAllStoredNumGraded;
    }

    /** @test */
    public function handle(){
        $this->expectsJobs(UpdateStoredNumGraded::class);
        $this->object->handle();
    }
}
