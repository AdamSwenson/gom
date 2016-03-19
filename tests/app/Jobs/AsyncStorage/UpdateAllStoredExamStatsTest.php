<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/18/16
 * Time: 3:16 PM
 */

namespace App\Jobs\AsyncStorage;


class UpdateAllStoredExamStatsTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new UpdateAllStoredExamStats;
    }

    /** @test */
    public function handle(){
        $this->expectsJobs(UpdateStoredExamStats::class);
        $this->object->handle();
    }

}
