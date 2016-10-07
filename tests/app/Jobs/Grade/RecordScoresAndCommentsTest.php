<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/30/16
 * Time: 4:27 PM
 */

namespace App\Jobs\Grade;


use App\ElementAssignment;
use App\Events\Ajax\PleaseSendAjaxFail;
use App\Events\Ajax\PleaseSendAjaxSuccess;
use App\Exam;
use App\Http\Requests\GradingRequest;
use App\Jobs\Feedback\BuildFeedbackOneStudent;
use App\QuestionAssignment;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Student;

class RecordScoresAndCommentsTest extends \TestCase
{

    protected $object;
    protected $request;
    protected $exam;
    protected $studentId;
    protected $elementAssignment;
    protected $questionAssignment;
    protected $elementId;
    protected $questionId;
    protected $commentText;
    protected $score;

    public function setUp()
    {
        parent::setUp();
        $this->exam = factory(Exam::class)->create();
        $this->studentId = factory(Student::class)->create()->id;
        $this->elementAssignment = factory(ElementAssignment::class)->create();
        $this->questionAssignment = factory(QuestionAssignment::class)->create();
        $this->elementId = $this->elementAssignment->element->id;
        $this->questionId = $this->questionAssignment->getQuestionId();

        $this->commentText = $this->faker->text;
        $this->score = $this->faker->randomFloat;

        $this->request = new GradingRequest();
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }


    /** @test */
    public function happyPathElementScoreWComment()
    {
        #prep
        $this->request['element_id'] = $this->elementId;
        $this->request['student_id'] = $this->studentId;
        $this->request['comment_text'] = $this->commentText;
        $this->request['score'] = $this->score;

        $daoMock = $this->createMock(IElementScoreRepository::class);
        $daoMock->shouldReceive('recordCommentText')
            ->with($this->elementAssignment->id, $this->studentId, $this->commentText)
            ->once();

        $daoMock->shouldReceive('record')
            ->with($this->elementAssignment->id, $this->studentId, $this->score)
            ->once();

        $elRepoMock = $this->createMock(IElementAssignmentRepository::class);
        $elRepoMock->shouldReceive('load_element_assignment_by_element')
            ->with($this->exam->id, $this->elementId)
            ->once()
            ->andReturn($this->elementAssignment);

        $this->expectsEvents(PleaseSendAjaxSuccess::class);

        #call
        $this->object = new RecordScoresAndComments($this->exam, $this->request);
        dispatch($this->object);
    }

    /** @test */
    public function happyPathElementScoreNoComment()
    {
        #prep
        $this->request['element_id'] = $this->elementId;
        $this->request['student_id'] = $this->studentId;
        $this->request['score'] = $this->score;

        $daoMock = $this->createMock(IElementScoreRepository::class);
        $elRepoMock = $this->createMock(IElementAssignmentRepository::class);

        $elRepoMock->shouldReceive('load_element_assignment_by_element')
            ->with($this->exam->id, $this->elementId)
            ->once()
            ->andReturn($this->elementAssignment);

        $daoMock->shouldNotReceive('recordCommentText');

        $daoMock->shouldReceive('record')
            ->with($this->elementAssignment->id, $this->studentId, $this->score)
            ->once();

        $this->expectsEvents(PleaseSendAjaxSuccess::class);

        #call
        $this->object = new RecordScoresAndComments($this->exam, $this->request);
        dispatch($this->object);
    }


    /** @test */
    public function happyPathCommentNoScore()
    {
        #prep
        $this->request['element_id'] = $this->elementId;
        $this->request['student_id'] = $this->studentId;
        $this->request['comment_text'] = $this->commentText;

        $elRepoMock = $this->createMock(IElementAssignmentRepository::class);
        $elRepoMock->shouldReceive('load_element_assignment_by_element')
            ->with($this->exam->id, $this->elementId)
            ->once()
            ->andReturn($this->elementAssignment);

        $daoMock = $this->createMock(IElementScoreRepository::class);
        $daoMock->shouldReceive('recordCommentText')
            ->with($this->elementAssignment->id, $this->studentId, $this->commentText)
            ->once();

        $daoMock->shouldNotReceive('record');

        $this->expectsEvents(PleaseSendAjaxSuccess::class);

        #call
        $this->object = new RecordScoresAndComments($this->exam, $this->request);
        dispatch($this->object);
    }


    /** @test */
    public function happyPathQuestionScore()
    {
        #prep
        $this->request['question_assignment_id'] = $this->questionAssignment->id;
        $this->request['student_id'] = $this->studentId;
        $this->request['score'] = $this->score;

        $daoMock = $this->createMock(IQuestionScoreRepository::class);
        $daoMock->shouldReceive('record')
            ->with($this->questionAssignment->id, $this->studentId, $this->score)
            ->once();

        $this->expectsEvents(PleaseSendAjaxSuccess::class);

        #call
        $this->object = new RecordScoresAndComments($this->exam, $this->request);
        dispatch($this->object);
    }


    /** @test */
    public function releasedExam(){
        #prep
        $this->exam->releaseExam();
        $this->assertTrue($this->exam->getReleased());

        $this->request['question_assignment_id'] = $this->questionAssignment->id;
        $this->request['student_id'] = $this->studentId;
        $this->request['score'] = $this->score;

        $this->expectsJobs(BuildFeedbackOneStudent::class);
        $this->expectsEvents(PleaseSendAjaxSuccess::class);

        #call
        $this->object = new RecordScoresAndComments($this->exam, $this->request);
        $this->object->handle();
//        dispatch($this->object);
    }

//
//    /**
//     * @test
//     * @expectedException Exception
//     */
//    public function problemCaseNoStudentId(){
//        $this->request['element_id'] = $this->elementId;
//        $this->request['comment_text'] = $this->commentText;
//        $this->request['score'] = $this->score;
//        $this->expectsEvents(PleaseSendAjaxFail::class);
//
//        #call
//        $this->object = new RecordScoresAndComments($this->exam, $this->request);
//        dispatch($this->object);
//    }
//




//    public function testRecordScoreQuestion()
//    {
//        $data = ['examId' => 1, 'question_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];
//        $mock = $this->createMock('App\Repositories\Score\IQuestionScoreRepository');
//        $mock->shouldReceive('record')
//            ->with([$data['question_assignment_id'], $data['student_id'], $data['score']])
//            ->andReturn(QuestionScore::all()->random());
//        $response = $this->action('POST', 'GradeController@recordScore', $data);
//        $this->assertNotNull($response);
//    }

    /*    public function testRecordScoreElement()
        {
            $data = ['examId' => 1, 'element_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];
            $mock = $this->createMock('App\Repositories\Score\IElementScoreRepository');
            $mock->shouldReceive('record')
                ->with([$data['element_assignment_id'], $data['student_id'], $data['score']])
                ->andReturn(ElementScore::all()->random());
            $response = $this->action('POST', 'GradeController@recordScore', $data);
            $this->assertNotNull($response);
        }*/


}
