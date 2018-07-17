<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/17/18
 * Time: 5:41 PM
 */
namespace App\Models\NewGom;

use App\Item;


use PHPUnit\Framework\Assert as PHPUnit;
class ItemScoreTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = factory(ItemScore::class)->make();
//        $this->object = new ItemScore();
//        $this->object->save();
    }

    public function tearDown()
    {
        parent::tearDown();
    }


    /** @test */
    public function countsTowardTotalScoreIsTrue()
    {
$this->object->item->counts_in_total = true;

        PHPUnit::assertTrue($this->object->countsTowardTotalScore());
    }


    /** @test */
    public function countsTowardTotalScoreIsFalse()
    {
        $this->object->item->counts_in_total = false;

        $item = \factory(Item::class)->create();
        $item->counts_in_total = true;
        $this->object->associate($item->id);
        $this->object->save();
        //check
        PHPUnit::assertTrue($this->object->countsTowardTotalScore());
    }

}
