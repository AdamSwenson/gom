<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/9/15
 * Time: 4:12 PM
 */

namespace App\classes\UserManagement\service;


use App\classes\UserManagement\service\UserSecrets;

class UserSecretsTest extends \TestCase
{

    protected $object;

    static public $username = 'testusername';
    static public $password = 'testpassword';
    static public $dbname = 'testdbname';
    static public $host = 'testhostname';

    public function setUp()
    {
        //parent::setUp();
//        $this->object = new UserSecrets;
    }

    protected function setVars()
    {
//        putenv(UserSecrets::VARNAME_DBNAME . "=" . self::$dbname);
//        putenv(UserSecrets::VARNAME_USERNAME . "=" . self::$username);
//        putenv(UserSecrets::VARNAME_PASSWORD . "=" . self::$password);
//        putenv(UserSecrets::VARNAME_HOST. "=" . self::$host);
    }

    public function testLoadCredentials()
    {
//        $this->setVars();
//        $this->object->loadCredentials();
//        $this->assertAttributeEquals(self::$username, 'username', $this->object);
//        $this->assertAttributeEquals(self::$password, 'password', $this->object);
//        $this->assertAttributeEquals(self::$host, 'host', $this->object);
//        $this->assertAttributeEquals(self::$dbname, 'databasename', $this->object);
    }



}
