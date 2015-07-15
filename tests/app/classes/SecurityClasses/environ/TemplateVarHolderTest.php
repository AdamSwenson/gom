<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/9/15
 * Time: 3:16 PM
 */

namespace App\classes\SecurityClasses\environ;


class TemplateVarHolderTest extends \TestCase
{

    protected $object;

    protected $stored = array();

    public function setUp()
    {
        $this->path1 = "test1/test1";
        $this->path2 = "test2/test2";
        foreach(TemplateVarHolder::$vars as $v){
            $this->stored[$v] = getenv($v);
        }
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        TemplateVarHolder::getInstance()->destroy();
        foreach($this->stored as $k => $v)
        {
            putenv("{$k}={$v}");
        }
    }

    public function setVars()
    {
        putenv(TemplateVarHolder::VARNAME_TEMPLATES . "={$this->path1}");
        putenv(TemplateVarHolder::VARNAME_CACHE . "={$this->path2}");
        TemplateVarHolder::getInstance()->destroy();
        $this->object = TemplateVarHolder::getInstance();
    }

    public function testGetPathToTemplateFolder()
    {
        $this->setVars();
        $this->assertEquals($this->path1, $this->object->getPathToTemplateFolder());
    }


    public function testGetPathToCacheFolder()
    {
        $this->setVars();
        $this->assertEquals($this->path2, $this->object->getPathToCacheFolder());
    }
}
