<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/9/15
 * Time: 6:43 PM
 */

namespace App\classes\UserManagement\service;


class SecretsTest extends \PHPUnit_Framework_TestCase {

    protected $object; 
    
    protected function setUp()
    {
        parent::setUp();
        //$this->object = new Secrets;
    }

    public function testProperlySetup()
    {
        $this->assertTrue(!empty(getenv("DB_HOST")));
        $this->assertEquals("localhost", getenv("DB_HOST"));

        $this->assertTrue(!empty(getenv("DB_NAME")));
        $this->assertEquals("gom_propel", getenv("DB_NAME"));

        $this->assertTrue(!empty(getenv("DB_USERNAME")));
        $this->assertEquals("testuser3", getenv("DB_USERNAME"));

        $this->assertTrue(!empty(getenv("DB_PASS")));
        $this->assertEquals("testpass3", getenv("DB_PASS"));

        $this->assertTrue(!empty(getenv("LOCATION")));
        $this->assertEquals("local", getenv("LOCATION"));

        $this->assertTrue(!empty(getenv("RUNTYPE")));
        $this->assertEquals("testing", getenv("RUNTYPE"));

        $this->assertTrue(!empty(getenv("DEVSTATE")));
        $this->assertEquals("development", getenv("DEVSTATE"));

    }
    public function testAll()
    {
        $this->object = Secrets::factory();
        $this->assertInstanceOf('\App\classes\UserManagement\service\SecretsParent', $this->object);
        $this->assertEquals("mysql:host=localhost;dbname=gom_propel", $this->object->getDsn());
        $this->assertEquals("testuser3", $this->object->getUsername());
        $this->assertEquals("gom_propel", $this->object->getDatabasename());
        $this->assertEquals("testpass3", $this->object->getPassword());
    }

    public function testFactoryOverrideUser()
    {
        $this->object = Secrets::factory(\App\classes\UserManagement\service\Secrets::USER);
        $this->assertInstanceOf('\App\classes\UserManagement\service\UserSecrets', $this->object);
    }

    public function testFactoryOverriderTest()
    {
        $this->object = Secrets::factory(\App\classes\UserManagement\service\Secrets::TEST);
        $this->assertInstanceOf('\App\classes\UserManagement\service\TestingSecrets', $this->object);
    }

//    public function testFactoryOverrideLive()
//    {
//        $this->object = Secrets::factory(\App\classes\UserManagement\service\Secrets::NORMAL);
//        $this->assertInstanceOf('\App\classes\UserManagement\service\LiveSecrets', $this->object);
//    }

}
