<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/25/15
 * Time: 1:40 PM
 */

namespace HTTP\Controllers\helpers\assignments;


use App\Http\Controllers\helpers\assignments\AssignmentHelper;

class AssignmentHelperTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new AssignmentHelper();
    }

    /**
     * @test
     */
    public function checkOrderNoDifferences()
    {
        $existing = [2, 25, 12, 24];
        $request = [2, 25, 12, 24];
        $result = $this->object->checkOrder($existing, $request);
        $this->assertEquals(0, count($result));
    }

    /**
     * @test
     */
    public function checkOrderSameIdsOneDifference()
    {
        $existing = [2, 25, 12, 24];
        $request = [2, 12, 25, 24];
        $result = $this->object->checkOrder($existing, $request);
        $this->assertEquals(2, count($result));
        $this->assertEquals([1, 2], $result);
    }

    /**
     * @test
     */
    public function checkOrderOneNewIdOneDifference()
    {
        $existing = [2, 25, 12, 24];
        $request = [1, 12, 25, 24];
        $result = $this->object->checkOrder($existing, $request);
        $this->assertEquals(3, count($result));
        $this->assertEquals([0, 1, 2], $result);
    }

    /**
     * @test
     */
    public function checkOrderAllNewIds()
    {
        $existing = [2, 27, 55, 29];
        $request = [1, 12, 25, 24];
        $result = $this->object->checkOrder($existing, $request);
        $this->assertEquals(4, count($result));
        $this->assertEquals([0, 1, 2, 3], $result);
    }


    /**
     * @test
     */
    public function findNewReturnsNew()
    {
        //prep
        $existing = [2, 25, 12, 24];
        $request = [1, 12, 25, 24];
        //call
        $result = $this->object->findNew($existing, $request);
        //check
        $this->assertEquals(1, count($result));
        $this->assertEquals([1], $result);
    }

    /**
     * @test
     */
    public function findNewReturnsNone()
    {
        //prep
        $existing = [2, 25, 12, 24];
        $request = [2, 25, 12, 24];
        //call
        $result = $this->object->findNew($existing, $request);
        //check
        $this->assertEquals(0, count($result));
    }

    /**
     * @test
     */
    public function findDeletedReturnsNone()
    {
        //prep
        $existing = [2, 25, 12, 24];
        $request = [2, 25, 12, 24];
        //call
        $result = $this->object->findDeleted($existing, $request);
        //check
        $this->assertEquals(0, count($result));
    }

    /**
     * @test
     */
    public function findDeletedReturnsOne()
    {
        //prep
        $existing = [2, 25, 12, 24];
        $request = [2, 25, 24];
        //call
        $result = $this->object->findDeleted($existing, $request);
        //check
        $this->assertEquals(1, count($result));
        $this->assertEquals([12], $result);
    }
}
