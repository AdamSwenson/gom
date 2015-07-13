<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/9/15
 * Time: 11:58 AM
 */

namespace SecurityClasses\environ;


use SecurityClasses\environ\EnvironVarHolder;

class EnvironVarHolderTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    public $stored = array();
    protected function setUp()
    {
        $this->path1 = "test1/test1";
        $this->path2 = "test2/test2";
        $this->path3 = "test3/test3";
        $this->path4 = "test4/test4";

        foreach(EnvironVarHolder::$vars as $v){
            $this->stored[$v] = getenv($v);
        }
        parent::setUp();
    }

    protected function tearDown()
    {
        EnvironVarHolder::getInstance()->destroy();
        foreach($this->stored as $k => $v)
        {
            putenv("{$k}={$v}");
        }
    }

    public function setVars()
    {
        EnvironVarHolder::getInstance()->destroy();

        putenv(EnvironVarHolder::VARNAME_ROOT_PATH . "={$this->path1}");
        putenv(EnvironVarHolder::VARNAME_VENDOR_PATH . "={$this->path2}");
        putenv(EnvironVarHolder::VARNAME_SRC_PATH . "={$this->path3}");
        putenv(EnvironVarHolder::VARNAME_PUBLIC_PATH . "={$this->path4}");
        $this->object = EnvironVarHolder::getInstance();
    }

    public function testGetPathToVendor()
    {
        $this->setVars();
        $this->assertEquals($this->path2, $this->object->getPathToVendor());
    }

    public function testGetPathToRoot()
    {
        $this->setVars();
        $this->assertEquals($this->path1, $this->object->getPathToRoot());
    }

    public function testGetPathToSrc()
    {
        $this->setVars();
        $this->assertEquals($this->path3, $this->object->getPathToSrc());
    }

    public function testGetPathToPublic()
    {
        $this->setVars();
        $this->assertEquals($this->path4, $this->object->getPathToPublic());
    }

    public function testGetLocation()
    {

        $vs = [
            EnvironVarHolder::LOCATION_LOCAL,
            EnvironVarHolder::LOCATION_REMOTE
        ];
        foreach ($vs as $v) {
            EnvironVarHolder::getInstance()->destroy();
            putenv(EnvironVarHolder::VARNAME_LOCATION . "={$v}");
            $this->object = EnvironVarHolder::getInstance();

            $this->assertEquals($v, $this->object->getLocation());
        }
    }


    public function testGetRuntype()
    {
        $vs = [
            EnvironVarHolder::RUNTYPE_NORMAL,
            EnvironVarHolder::RUNTYPE_TESTING
        ];
        foreach ($vs as $v) {
            EnvironVarHolder::getInstance()->destroy();
            putenv(EnvironVarHolder::VARNAME_RUNTYPE . "={$v}");
            $this->object = EnvironVarHolder::getInstance();
            $this->assertEquals($v, $this->object->getRuntype());
        }
    }


    public function testGetDevstate()
    {
        $vs = [
            EnvironVarHolder::DEVSTATE_DEVELOPMENT,
            EnvironVarHolder::DEVSTATE_LIVE
        ];
        foreach ($vs as $v) {
            EnvironVarHolder::getInstance()->destroy();
            putenv(EnvironVarHolder::VARNAME_DEVSTATE . "={$v}");
            $this->object = EnvironVarHolder::getInstance();
            $this->assertEquals($v, $this->object->getDevstate());
        }
    }


    public function testIsTest()
    {
        $vs = [
            EnvironVarHolder::RUNTYPE_NORMAL => false,
            EnvironVarHolder::RUNTYPE_TESTING => true
        ];
        foreach ($vs as $k => $v) {
            EnvironVarHolder::getInstance()->destroy();
            putenv(EnvironVarHolder::VARNAME_RUNTYPE . "={$k}");
            $this->object = EnvironVarHolder::getInstance();

            $this->assertEquals($k, $this->object->getRuntype());
            $this->assertEquals($v, $this->object->isTest());
        }
    }

    public function testIsDevelopment()
    {
        $vs = [
            EnvironVarHolder::DEVSTATE_DEVELOPMENT => true,
            EnvironVarHolder::DEVSTATE_LIVE => false
        ];
        foreach ($vs as $k => $v) {
            EnvironVarHolder::getInstance()->destroy();
            putenv(EnvironVarHolder::VARNAME_DEVSTATE . "={$k}");
            $this->object = EnvironVarHolder::getInstance();

            $this->assertEquals($k, $this->object->getDevstate());
            $this->assertEquals($v, $this->object->isDevelopment());
        }
    }

    public function testIsLocal()
    {
        $vs = [
            EnvironVarHolder::LOCATION_LOCAL => true,
            EnvironVarHolder::LOCATION_REMOTE => false
        ];
        foreach ($vs as $k => $v) {
            EnvironVarHolder::getInstance()->destroy();
            putenv(EnvironVarHolder::VARNAME_LOCATION . "={$k}");
            $this->object = EnvironVarHolder::getInstance();
            $this->assertEquals($k, $this->object->getLocation());
            $this->assertEquals($v, $this->object->isLocal());
        }
    }

    public function testIsRemote()
    {
        $vs = [
            EnvironVarHolder::LOCATION_LOCAL => false,
            EnvironVarHolder::LOCATION_REMOTE => true
        ];
        foreach ($vs as $k => $v) {
            EnvironVarHolder::getInstance()->destroy();
            putenv(EnvironVarHolder::VARNAME_LOCATION . "={$k}");
            $this->object = EnvironVarHolder::getInstance();
            $this->assertEquals($k, $this->object->getLocation());
            $this->assertEquals($v, $this->object->isRemote());
        }
    }
}
