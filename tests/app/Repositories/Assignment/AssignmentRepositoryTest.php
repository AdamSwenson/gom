<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/15/17
 * Time: 6:06 PM
 */

namespace App\Repositories\Assignment;


use App\Assignment;
use App\Exam;

class AssignmentRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new AssignmentRepository;
    }

    /** @test */
    public function make_fake(){
        $result = AssignmentRepository::makeFake();
//        dd($result);
        echo $result;
        $this->assertInstanceOf(Assignment::class, $result);
    var_dump($result->getChildren());
    }


    /** @test */
    public function processIncoming(Exam $exam, $incoming)
    {
        $numLevels = 3;
        $numAtLevel = 3;
        $exam = factory(Exam::class)->create();
        $items = factory(Element::class, 12)->create();


    }

}
