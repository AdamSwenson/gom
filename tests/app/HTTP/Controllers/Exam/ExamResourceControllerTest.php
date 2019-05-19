<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 2019-04-20
 * Time: 18:57
 */

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\Http\Controllers\ItemController;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class ExamResourceControllerTest extends \TestCase
{

    use WithoutMiddleware;
    protected $route = 'dev/exam';
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ExamResourceController;
    }


    /**
     * @test
     */
    public function handleUpdate_EmptySetsToNull()
    {

        $exam = factory(Exam::class)->make();
        $exam->save();
        foreach ( $this->object->updatable as $f ) {
            $test = '';

            $data = new Request();
            $data[$f] = $test;
            $objectField = snake_case($f);

            //call
            $e = $this->object->update($data, $exam);

            //check
            $this->assertNull($exam->$objectField, $objectField);
            $this->assertNull($e->$objectField, $objectField);
        }
    }


    /**
     * This let's us test the update function without
     * using the Laravel request stack
     * @test
     */
    public function handleUpdate_UpdatesField()
    {
        $exam = factory(Exam::class)->make();
        $exam->save();
        foreach ( $this->object->updatable as $f ) {

            if ( $f === 'customMaxScore' ) {
                //numerical
                $test = Factory::create()->randomNumber(3);
            } elseif ( $f === 'year' ) {
                //year
                $test = Factory::create()->year;
            } else {
                //string cases
                $test = Factory::create()->sentence;
            }

            $data = new Request();
            $data[$f] = $test;
            $objectField = snake_case($f);

            //call
            $e = $this->object->update($data, $exam);

            //check
            $this->assertEquals($test, $exam->$objectField, $objectField);
            $this->assertEquals($test, $e->$objectField, $objectField);
        }
    }

    /**
     * @test
     */
    public function update_UpdatesField()
    {
        $exam = factory(Exam::class)->make();
        $exam->save();
        foreach ( $this->object->updatable as $f ) {


            if ( $f === 'customMaxScore' ) {
                //numerical
                $test = Factory::create()->randomNumber(3);
            } elseif ( $f === 'year' ) {
                //year
                $test = Factory::create()->year;
            } else {
                //string cases
                $test = Factory::create()->sentence;
            }

            $data = [$f => $test];
            $objectField = snake_case($f);

            //call
            $response = $this->put($this->route . '/' . $exam->id, $data);

            //check
            $response->assertStatus(200);
            $e = Exam::whereId($exam->id)->first();
//            dd($e);
            $this->assertEquals($test, $exam->$objectField, $objectField);

//            $this->assertEquals($test, $e->$objectField, $objectField);
        }
    }

    /**
     * @test
     */
    public function castEmptyToNullWorks()
    {
        $data = ['customMaxScore' => ''];
        //empty string case
        $this->assertNull($this->object->castEmptyToNull($data['customMaxScore']));

    }

}
