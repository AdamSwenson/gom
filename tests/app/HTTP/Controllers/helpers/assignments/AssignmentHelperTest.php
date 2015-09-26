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
    public function determineCaseNoChange()
    {
        $result = $this->object->determineCase([1, 2, 3], [1, 2, 3]);
        $this->assertEquals(AssignmentHelper::CASE_NO_CHANGE, $result);

        //make sure does not return no change if there has been reordering
        $result = $this->object->determineCase([1, 2, 3], [1, 3, 2]);
        $this->assertNotEquals(AssignmentHelper::CASE_NO_CHANGE, $result);
    }

    /**
     * @test
     */
    public function determineCasePureAddition()
    {
        $result = $this->object->determineCase([], [1, 2, 3]);
        $this->assertEquals(AssignmentHelper::CASE_PURE_ADDITION, $result);
    }

    /**
     * @test
     */
    public function determineCasePureDeletion()
    {
        $result = $this->object->determineCase([1, 2, 3], []);
        $this->assertEquals(AssignmentHelper::CASE_PURE_DELETION, $result);
    }


    /**
     * @test
     */
    public function determineCaseImpureWhereItemHasBeenReplaced()
    {
        $result = $this->object->determineCase([1, 2, 3], [1, 4, 3]);
        $this->assertEquals(AssignmentHelper::CASE_IMPURE, $result);
        $this->assertAttributeEquals([4], 'newIds', $this->object);
        $this->assertAttributeEquals([2], 'deletedIds', $this->object);
    }

    /**
     * @test
     */
    public function determineCaseWhereSameIdsHaveBeenShuffled()
    {
        $result = $this->object->determineCase([1, 2, 3], [1, 3, 2]);
        //check
        $this->assertEquals(AssignmentHelper::CASE_IMPURE, $result);
        $this->assertAttributeEquals([], 'newIds', $this->object);
        $this->assertAttributeEquals([], 'deletedIds', $this->object);

//        $expected = [
//            ['order'=> 1, 'existingId'=> 2, 'requestId'=>3],
//            ['order'=> 2, 'existingId'=> 3, 'requestId'=>2]
//        ];
//        $this->assertAttributeEquals($expected, 'changedItems', $this->object);
    }


//
//    /**
//     * @test
//     */
//    public function checkOrderNoDifferences()
//    {
//        $existing = [2, 25, 12, 24];
//        $request = [2, 25, 12, 24];
//        $result = $this->object->checkOrder($existing, $request);
//        $this->assertEquals(0, count($result));
//    }
//
//    /**
//     * @test
//     */
//    public function checkOrderSameIdsOneDifference()
//    {
//        $existing = [2, 25, 12, 24];
//        $request = [2, 12, 25, 24];
//        //call
//        $result = $this->object->checkOrder($existing, $request);
//        //check
//        $this->assertEquals(2, count($result));
//        $expect = [
//            ['order' => 1, 'existingId' => 25, 'requestId' => 12,],
//            ['order' => 2, 'existingId' => 12, 'requestId' => 25]];
//        $this->assertEquals($expect, $result);
//    }
//
//    /**
//     * @test
//     */
//    public function checkOrderOneNewIdOneDifference()
//    {
//        $existing = [2, 25, 12, 24];
//        $request = [1, 12, 25, 24];
//        $result = $this->object->checkOrder($existing, $request);
//        $this->assertEquals(3, count($result));
//        $expect = [
//            ['order' => 0, 'existingId' => 2, 'requestId' => 1],
//            ['order' => 1, 'existingId' => 25, 'requestId' => 12],
//            ['order' => 2, 'existingId' => 12, 'requestId' => 25]];
//        $this->assertEquals($expect, $result);
//    }
//
//    /**
//     * @test
//     */
//    public function checkOrderAllNewIds()
//    {
//        //prep
//        $existing = [2, 27, 55, 29];
//        $request = [1, 12, 25, 24];
//        //call
//        $result = $this->object->checkOrder($existing, $request);
//        //check
//        $this->assertEquals(4, count($result));
//        $expect = [
//            ['order' => 0, 'existingId' => 2, 'requestId' => 1],
//            ['order' => 1, 'existingId' => 27, 'requestId' => 12],
//            ['order' => 2, 'existingId' => 55, 'requestId' => 25],
//            ['order' => 3, 'existingId' => 29, 'requestId' => 24]];
//        $this->assertEquals($expect, $result);
//    }


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
