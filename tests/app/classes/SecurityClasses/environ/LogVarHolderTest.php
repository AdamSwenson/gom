<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/9/15
 * Time: 10:58 AM
 */

namespace App\classes\SecurityClasses\environ;


use App\classes\SecurityClasses\environ\LogVarHolder;

class LogVarHolderTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected $stored = array();


    protected function setUp()
    {
        $this->path1 = "test1/test1";
        $this->path2 = "test2/test2";
        foreach(LogVarHolder::$vars as $v){
            $this->stored[$v] = getenv($v);
        }
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
        LogVarHolder::getInstance()->destroy();
        foreach($this->stored as $k => $v)
        {
            putenv("{$k}={$v}");
        }
//        putenv("APP_ROOT_PATH=''");
 //       putenv("APP_LOG_PATH=''");
    }

    public function setVars()
    {
        putenv(LogVarHolder::VARNAME_ROOT_PATH . "={$this->path1}");
        putenv(LogVarHolder::VARNAME_LOG_PATH  . "={$this->path2}");
        LogVarHolder::getInstance()->destroy();
        $this->object = LogVarHolder::getInstance();
    }

    public function testGetPathToRoot()
    {
        $this->setVars();
        $this->assertEquals($this->path1, $this->object->getPathToRoot());
    }

    public function testGetPathToLogRoot()
    {
        $this->setVars();
        $this->assertEquals($this->path2, $this->object->getPathToLogRoot());
    }

    public function testGetPathToErrorLog()
    {
        $this->setVars();
        $expect = $this->path2 . '/' . LogVarHolder::ERROR_LOG_NAME . '.html';
        $this->assertEquals($expect, $this->object->getPathToErrorLog());
    }

    public function testGetPathToUsersQueryLog()
    {
        $this->setVars();
        $expect = $this->path2 . '/' . LogVarHolder::USERS_QUERY_LOG_NAME . '.html';
        $this->assertEquals($expect, $this->object->getPathToUsersQueryLog());
    }

    public function testGetUsersQueryLogName()
    {
        $this->setVars();
        $this->assertEquals(LogVarHolder::USERS_QUERY_LOG_NAME,
            $this->object->getUsersQueryLogName());
    }

    public function testGetPathToQueryLog()
    {
        $this->setVars();
        $expect = $this->path2 . '/' . LogVarHolder::QUERY_LOG_NAME . '.html';
        $this->assertEquals($expect, $this->object->getPathToQueryLog());
    }

//    /**
//     * @expectedException \App\classes\SecurityClasses\errors\EnvironmentException;
//     */
//    public function testGetPathToRootException()
//    {
//        $this->object = LogVarHolder::getInstance();
//        $this->object->getPathToRoot();
//    }
//
//    /**
//     * @expectedException \App\classes\SecurityClasses\errors\EnvironmentException;
//     */
//    public function testGetPathToLogRootException()
//    {
//        $this->object = LogVarHolder::getInstance();
//        $this->object->getPathToLogRoot();
//    }
//
//    /**
//     * @expectedException \App\classes\SecurityClasses\errors\EnvironmentException;
//     */
//    public function testGetPathToErrorLogException()
//    {
//        $this->object = LogVarHolder::getInstance();
//        $this->object->getPathToErrorLog();
//    }
//
//    /**
//     * @expectedException \App\classes\SecurityClasses\errors\EnvironmentException;
//     */
//    public function testGetPathToUsersQueryLogException()
//    {
//        $this->object = LogVarHolder::getInstance();
//        $this->object->getPathToUsersQueryLog();
//    }
//
//    /**
//     * @expectedException \Exception;
//     */
//    public function testGetPathToQueryLogException()
//    {
//        $this->object = LogVarHolder::getInstance();
//        $this->object->getPathToQueryLog();
//    }
}
