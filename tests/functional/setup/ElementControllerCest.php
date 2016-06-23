<?php


use App\Element;
use App\Exam;
use App\Http\Controllers\ElementController;
use App\Http\Requests\ElementRequest;
use App\Question;
use App\QuestionAssignment;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Page\ElementEditPage;


class ElementControllerCest
{

    public $element;
    public $elementDaoMock;
    public $assignmentDaoMock;
    protected $object;

    public function _before(FunctionalTester $I)
    {
        
        $this->assignmentDaoMock = $this->createMock('\App\Repositories\Element\IElementAssignmentRepository');
        $this->element = Element::all()->random();
    }

    public function _after(FunctionalTester $I)
    {
    }


    public function testIndex(FunctionalTester $I)
    {
        $examId = 5;
        $questionNumber = 4;

        $this->elementDaoMock->shouldReceive('load_element_assignments_by_question_number')
            ->with($examId, $questionNumber)
            ->once()
            ->andReturn(Element::all());

        $request = new ElementRequest();
        $request['exam_id'] = $examId;
        $request['question_number'] = $questionNumber;


        //call
        $object = new ElementController;
        $response = $object->index($request);
        $this->assertNotNull($response);

//        $response = $this->action('GET', 'ElementController@index', $data);

    }


    public function testStore(FunctionalTester $I)
    {

        $element = new Element();
        $element->id = $this->faker->randomNumber(4);


        $data = [
            'elementName' => $this->faker->text(8),
            'respGeneric' => $this->faker->text(),
            'respAbsent'  => $this->faker->text(),
            'respPoor'    => $this->faker->text(),
            'respGood'    => $this->faker->text(),
        ];
        $data2 = [
            'examId'         => $this->faker->randomNumber(3),
            'elementId'      => $element->getId(),
            'questionNumber' => $this->faker->randomDigit(),
            'subtask'        => $this->faker->randomDigit(),
        ];

        $request['elementName'] = $this->faker->text(8);
        $request['respGeneric'] = $this->faker->text();
        $request['respAbsent'] = $this->faker->text();
        $request['respPoor'] = $this->faker->text();
        $request['respGood'] = $this->faker->text();


        $this->elementDaoMock->shouldReceive('createElement')
            ->with($data)
            ->once()
            ->andReturn($element);
        $this->assignmentDaoMock->shouldReceive('record')
            ->with($data2)
            ->once();


        $request = new ElementRequest();
//        $request['exam_id'] = $examId;
//        $request['question_number'] = $questionNumber;

        $request['elementName'] = $this->faker->text(8);
        $request['respGeneric'] = $this->faker->text();
        $request['respAbsent'] = $this->faker->text();
        $request['respPoor'] = $this->faker->text();
        $request['respGood'] = $this->faker->text();


        //call
        $object = new ElementController;
        $response = $object->index($request);
//        $this->assertNotNull($response);
//
////        $response = $this->action('GET', 'ElementController@index', $data);


        $response = $this->action('POST', 'ElementController@create', $data);
        $this->assertNotNull($response);
    }


    public function testEditAll(FunctionalTester $I)
    {
        $qnum = 3;

        $qa = factory(QuestionAssignment::class)->create();
        $exam = Exam::find($qa->exam_id);
        $question = Question::find($qa->question_id);

        $qa2 = factory(QuestionAssignment::class)->create();

        $assignmentDao = $this->createMock(IQuestionAssignmentRepository::class);
        $assignmentDao->shouldReceive('load_all_for_exam')
            ->with($exam->id)
            ->once()
            ->andReturn([$qa, $qa2]);
        $assignmentDao->shouldReceive('loadQuestionNumberById')
            ->with($exam->id, $question->id)
            ->once()
            ->andReturn($qnum);

        $elementAssignmentDaoMock = $this->createMock(IElementAssignmentRepository::class);
        $elementAssignmentDaoMock->shouldReceive('load_elements')
            ->with($exam->id, $qnum)
            ->once()
            ->andReturn(Element::all()->take(5));

        $object = new ElementController;
        $response = $object->editAll($exam, $question);
        $this->assertNotNull($response);
    }

    public function buildIncomingArray($number)
    {
        return [
            "elementName{$number}" => $this->faker->text(),
            "elementId{$number}"   => $this->faker->randomNumber(),
            "elementText{$number}" => $this->faker->text(),
            "e{$number}valence0"   => $this->faker->text(),
            "e{$number}valence1"   => $this->faker->text(),
            "e{$number}valence2"   => $this->faker->text(),
            "e{$number}valence3"   => $this->faker->text(),
        ];
    }


    public function testUpdateAll(FunctionalTester $I)
    {
        $exam = factory(Exam::class)->create();
        $question = factory(Question::class)->create();

        $request = new ElementRequest();
        $request['nextAction'] = 'editQuestions';

        $this->assignmentDaoMock->shouldReceive('updateAll')
            ->with($exam, $question, $request)
            ->once();

        $object = new ElementController;
        $response = $object->updateAll($exam, $question, $request);
        $this->assertNotNull($response);
    }

/*_token:7eJvSALTO6lXLMHP1q03nVeVHv8OhoEBghrj67KJ
elementName1:q1e1
elementText1:q1e1
e1valence0:                            m
e1valence1:q1e1 p
e1valence2:q1e1 f
e1valence3:q1e1 e
elementId1:0
nextAction:editStudents*/
    public function testUpdateAllExistingElement(FunctionalTester $I) //$exam, $question, ElementRequest $request)
    {
        $elementId = 2;
        $element = new Element();
        $element->id = $elementId;
        $examId = 1;
        $questionId = 1;

        $data = $this->buildIncomingArray(2);
        $data['examId'] = $examId;
        $data['questionId'] = $questionId;

        $this->elementDaoMock->shouldReceive('editElement')
            ->with([$data['elementName2'], '', $data['elementText2']])
            ->andReturn($element);

        $this->assignmentDaoMock->shouldReceive('record')->with($examId, $questionId, $elementId, 1);

        $response = $this->action('POST', 'ElementController@updateAll', $data);
        $this->assertNotNull($response);


        $data = [
            $this->buildIncomingArray(1),
            $this->buildIncomingArray(2),
        ];

        $this->assignmentDaoMock->shouldReceive('record');
        $this->markTestIncomplete();
    }

    public function testDestroy(FunctionalTester $I)
    {
        $this->elementDaoMock->shouldReceive('deleteElement')->with($this->element);

        $response = $this->action('POST', 'ElementController@destroy', $this->element);
        $this->assertNotNull($response);
    }


}
