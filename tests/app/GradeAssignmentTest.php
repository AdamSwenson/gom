<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/12/15
 * Time: 5:40 PM
 */

namespace App;


use App\Repositories\Grade\GradeFactory;

class GradeAssignmentTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new GradeAssignment;
    }


    public function testGetGradeAttribute()
    {
        foreach(GradeFactory::$grades as $grade)
        {
            //Create new assignment
            $g = new GradeAssignment();
            //Set the grade_id
            $g->grade_id = $grade['grade_id'];

            //verify that the grade property is unset
            $this->assertAttributeEmpty('grade', $g, 'grade is unset');

            //get the grade
            $result = $g->getGradeAttribute();

            //check
            $this->assertInstanceOf('App\Grade', $result);
            $this->assertEquals($grade['grade_id'], $result->id, 'result has correct id');
            $this->assertEquals($grade['display_value'], $result->display_value, 'result has correct display value');
            $this->assertEquals($grade['calc_value'], $result->calc_value, 'result has correct calc value');

        }
    }

    public function testGetGrade()
    {
        foreach(GradeFactory::$grades as $grade)
        {
            //Create new assignment
            $g = new GradeAssignment();
            //Set the grade_id
            $g->grade_id = $grade['grade_id'];

            //verify that the grade property is unset
            $this->assertAttributeEmpty('grade', $g, 'grade is unset');

            //get the grade
            $result = $g->getGrade();

            //check
            $this->assertInstanceOf('App\Grade', $result);
            $this->assertEquals($grade['grade_id'], $result->id, 'result has correct id');
            $this->assertEquals($grade['display_value'], $result->display_value, 'result has correct display value');
            $this->assertEquals($grade['calc_value'], $result->calc_value, 'result has correct calc value');

        }
    }


    public function testSetGrade()
    {
        for($i=0; $i<count(GradeFactory::$grades); $i++)
        {
            //Create new assignment
            $g = new GradeAssignment();

            $t = GradeFactory::loadByOrder($i);

            //Set the grade
            $g->setGrade($t);

            //check
            $this->assertInstanceOf('App\Grade', $g->grade, 'grade object saved in grade property');
            $this->assertAttributeEquals($t, 'grade', $g, 'correct grade object saved in grade property');
            $this->assertEquals(GradeFactory::$grades[$i]['grade_id'], $g->grade_id, 'grade id saved in grade_id property');
        }
    }


    /**
     * Dealing with bug in recording grades with min score of zero
     * @test
     */
    public function setGradeWithMinScoreOfZero()
    {
        //Create new assignment
        $g = new GradeAssignment();

        $t = GradeFactory::loadByDisplayValue('F');

        //Set the grade
        $g->setGrade($t);
        $g->setMinScore(0);
        $g->exam_id = 1;
        //Save it
        $g->save();

        $this->seeInDatabase('grade_assignments', ['exam_id' => 0, 'grade_id' => 112, 'min_score' => 0]);

    }




}
