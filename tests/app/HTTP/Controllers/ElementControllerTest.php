<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 11:06 AM
 */

namespace HTTP\Controllers;

use App\Element;
use App\Http\Requests\ElementRequest;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class ElementControllerTest extends \TestCase
{
    use WithoutMiddleware;

    public $element;
    public $elementDaoMock;
    public $assignmentDaoMock;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->elementDaoMock = $this->createMock('\App\Repositories\Element\IElementRepository');
        $this->assignmentDaoMock = $this->createMock('\App\Repositories\Element\IElementAssignmentRepository');
        $this->element = Element::all()->random();
    }


    public function testIndex()
    {
        $data = ['examId' => 5, 'question_number' => 4];
        $this->elementDaoMock->shouldReceive('load_element_assignments_by_question_number')
            ->with($data)
            ->andReturn(Element::all());
        $response = $this->action('GET', 'ElementController@index', $data);
        $this->assertNotNull($response);
    }


    public function testCreate()
    {
    }


    public function testStore(ElementRequest $request)
    {

        $element = new Element();
        $element->id = $this->faker->randomNumber(4);

        $data = [
            'elementName' => $this->faker->text(8),
            'respGeneric' => $this->faker->text(),
            'respAbsent' => $this->faker->text(),
            'respPoor' => $this->faker->text(),
            'respGood' => $this->faker->text()
        ];
        $data2 = [
            'examId' => $this->faker->randomNumber(3),
            'elementId' => $element->getId(),
            'questionNumber' => $this->faker->randomDigit(),
            'subtask' => $this->faker->randomDigit()
        ];

        $this->elementDaoMock->shouldReceive('createElement')->with($data)->andReturn($element);
        $this->assignmentDaoMock->shouldReceive('record')->with($data2);

        $response = $this->action('POST', 'ElementController@create', $data);
        $this->assertNotNull($response);
    }


    public function testShow()
    {
        $data = ['elementId' => $this->faker->randomNumber(4)];
        $response = $this->elementDaoMock->shouldReceive('loadElementById')->with($data)->andReturn($this->element);
        $response = $this->action('POST', 'ElementController@show', $data);
    }

    public function testEdit(Element $element, ElementRequest $request)
    {

    }


    public function testUpdate(Element $element, ElementRequest $request)
    {

    }


    public function testDestroy()
    {
        $this->elementDaoMock->shouldReceive('deleteElement')->with($this->element);

        $response = $this->action('POST', 'ElementController@destroy', $this->element);
        $this->assertNotNull($response);
    }


}
