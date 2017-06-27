<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/8/17
 * Time: 5:41 PM
 */

namespace App;


use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ItemTest;
    }

}
