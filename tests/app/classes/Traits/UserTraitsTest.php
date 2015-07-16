<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/15
 * Time: 11:00 AM
 */

namespace App\classes\Traits;

use App\User;
use Auth;

class UserTraitsTest extends \TestCase
{
    public static $userid = 1;
    protected $object;

    public function setUp()
    {
        parent::setUp();

        Auth::loginUsingId(self::$userid);

//        Auth::shouldReceive('check')
//            ->once()
//            ->andReturn('true');
//
//        Auth::shouldReceive('user')
//            ->once()
//            ->andReturn($user);

        $this->object = $this->getMockForTrait('App\classes\Traits\UserTraits');
    }

    public function testGetUser()
    {
        $user = $this->object->getUser();
        $this->assertTrue(!empty($user));
        $this->assertInstanceOf('\User', $user);
        $this->assertEquals(self::$userid, $user->getId());
     }

    public function testGetId()
    {
        $this->assertEquals(self::$userid, $this->object->getId());

    }
}
