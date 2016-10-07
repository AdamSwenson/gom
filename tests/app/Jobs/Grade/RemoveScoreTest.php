<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/4/16
 * Time: 5:57 PM
 */

namespace App\Jobs\Grade;


use App\Element;
use App\Events\AsyncJobCompleteEvent;
use App\Exam;
use App\Http\Requests\GradingRequest;
use App\Jobs\Grade\RemoveScore;
use App\QuestionAssignment;
use App\Repositories\Element\ElementAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Student;

class RemoveScoreTest extends \TestCase
{

    protected $object;
    protected $request;
    protected $exam;
    protected $student;
    protected $questionAssignment;

    public function setUp()
    {
        parent::setUp();

        $this->request = new GradingRequest();
        $this->exam = factory(Exam::class)->create();
        $this->student = factory(Student::class)->create();

        $this->questionAssignment = factory(QuestionAssignment::class)->create();

    }



    public function testRemoveScoreQuestion(){
        #prep
        $this->request['question_assignment_id'] = 1;
        $this->request['student_id'] = $this->student->id;

        $mock = $this->createMock(IQuestionScoreRepository::class);
        $mock->shouldReceive('deleteScore')
            ->once()
            ->with($this->questionAssignment->id, $this->student->id);

        $this->expectsEvents(AsyncJobCompleteEvent::class);

        #call
        $this->object = new RemoveScore($this->exam, $this->request);
        $this->object->handle();
    }


    /**
     * @test
     */
    public function removeScoreElement()
    {
        $element = factory(Element::class)->create();
        $this->request['element_id'] = $element->id;
        $this->request['student_id'] = $this->student->id;

        $mock1 = $this->createMock(ElementAssignmentRepository::class);
        $mock1->shouldReceive('load_element_assignment_by_element')
            ->once()
            ->with($this->exam->id, $element->id)
            ->andReturn($element->id);

        $mock2 = $this->createMock(IElementScoreRepository::class);
        $mock2->shouldReceive('deleteScore')
            ->once()
            ->with($element->id, $this->student->id);

        $this->expectsEvents(AsyncJobCompleteEvent::class);

        #call
        $this->object = new RemoveScore($this->exam, $this->request);
        $this->object->handle();
    }

}
