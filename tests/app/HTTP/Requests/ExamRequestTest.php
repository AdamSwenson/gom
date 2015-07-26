<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/24/15
 * Time: 5:11 PM
 */

namespace HTTP\Requests;


use App\Http\Requests\ExamRequest;

class ExamRequestTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        //$this->object = new ExamRequest();
    }


    public function testFilter()
    {

        $examName = $this->faker->text(5);
        $term = $this->faker->text(5);
        $year = $this->faker->year();

        $request = $this->post('/exam/create',
            ['name' => $examName,
            'term' => $term,
            'year' => $year
            ]);
        var_dump($request);
        $this->assertNotEmpty($request);
        $this->assertInstanceOf('\App\HTTP\Requests\ExamRequest', $request);
//        $request = new ExamRequest();
//        $request->input('name', $examName);
//        $request->input('term', $term);
//        $request->input('year', $year);

//        $this->object->store($request);
    }

}
