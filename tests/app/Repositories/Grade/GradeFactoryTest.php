<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/22/15
 * Time: 4:41 PM
 */

namespace App\Repositories\Grade;


use App\Repositories\Grade\GradeFactory;

class GradeFactoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function factory_returns_correct_object_for_display_values()
    {
        foreach(GradeFactory::$grades as $grade)
        {
            $result = GradeFactory::loadByDisplayValue($grade['display_value']);

            $this->assertInstanceOf('App\Grade', $result, "returns a grade object");
            $this->assertEquals($grade['grade_id'], $result->id, "returns correct id");
            $this->assertEquals($grade['display_value'], $result->display_value, "returns correct display value");
            $this->assertEquals($grade['calc_value'], $result->calc_value, "returns correct calc value");
        }
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function factory_throws_exception_on_bad_display_value()
    {
        GradeFactory::loadByDisplayValue('F+');
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function factory_throws_exception_on_empty_string_display_value()
    {
        GradeFactory::loadByDisplayValue('');
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function factory_throws_exception_on_boolean_true_display_value()
    {
        GradeFactory::loadByDisplayValue(true);
    }


}
