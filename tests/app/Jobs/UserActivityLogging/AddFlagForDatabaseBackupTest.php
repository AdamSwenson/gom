<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/21/16
 * Time: 3:41 PM
 */

namespace App\Jobs\UserActivityLogging;


use App\Repositories\Utilities\IBackupFlagRepository;
use App\User;

class AddFlagForDatabaseBackupTest extends \TestCase
{

    protected $object;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = User::all()->random();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testHandle(){
        //prep
        $dao = \Mockery::mock(IBackupFlagRepository::class);
        $dao->shouldReceive('setFlag')->once()->andReturn(true);
        $this->registerMock(IBackupFlagRepository::class, $dao);

        //call
        $this->object = new AddFlagForDatabaseBackup($this->user);
        $this->object->handle();
    }

}
