<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 6:22 PM
 */

namespace App\Repositories\Feedback;


use App\Exam;
use App\QuestionAssignment;
use App\Repositories\Element\CommentRepository;
use App\Repositories\Element\ElementAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Question\QuestionAssignmentRepository;
use App\Repositories\Score\ElementScoreRepository;
use App\Repositories\Score\QuestionScoreRepository;
use App\Repositories\Student\StudentRepository;
use App\Student;
use Mockery\Mock;

class FeedbackBuilderTest extends \TestCase
{
//    use \TestTraits;

    protected $object;
    protected $questionAssignmentRepository;
    protected $elementAssignmentRepository;
    protected $questionScoreRepository;
    protected $elementScoreRepository;
    protected $commentRepository;
    protected $studentRepository;

    public function setUp()
    {
        parent::setUp();

        $this->questionAssignmentRepository = $this->makeMock('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->elementAssignmentRepository = $this->makeMock('App\Repositories\Element\IElementAssignmentRepository');
        $this->questionScoreRepository = $this->makeMock('App\Repositories\Score\IQuestionScoreRepository');
        $this->elementScoreRepository = $this->makeMock('App\Repositories\Score\IElementScoreRepository');
        $this->commentRepository = $this->makeMock('App\Repositories\Element\ICommentRepository');
        $this->studentRepository = $this->makeMock('App\Repositories\Student\IStudentRepository');
        $this->object = new FeedbackBuilder();

        $ex = Exam::all()->random(1);
        $this->exam = $ex[0];

    }

    public function makeMock($class)
    {
        $mock = \Mockery::mock($class);
        $this->app->instance($class, $mock);

        return $mock;
    }

    public function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }


    public function testLoadStudents()
    {
        $examId = 1;
        $number = $this->faker->randomDigit();
        $this->assertEmpty($this->object->students);
        $students = factory('App\Student', $number)->make();
        $this->studentRepository->shouldReceive('load_students_by_exam')
            ->with($examId)
            ->andReturn($students);

        $this->object->loadStudents($examId);
        $this->assertEquals($number, count($this->object->students));
    }

    public function buildQuestionAssignmentMock($number)
    {
        $questionAssignment = \Mockery::mock('App\QuestionAssignment');
        $questionAssignment->shouldReceive('getQuestionAssignmentId')->andReturn($number);
        $questionAssignment->shouldReceive('getQuestionId')->andReturn($number);
        $questionAssignment->shouldReceive('getQuestionName')->andReturn("questionName{$number}");
        $questionAssignment->shouldReceive('getQuestionNumber')->andReturn($number);

        return $questionAssignment;
    }

    public function buildElementAssignmentMock($number)
    {
        $elementAssignment = \Mockery::mock('App\ElementAssignment');
        $elementAssignment->shouldReceive('getSubtask')->andReturn($number);
        $elementAssignment->shouldReceive('getElementId')->andReturn($number);
        $elementAssignment->shouldReceive('getElementAssignmentId')->andReturn($number);
        $elementAssignment->shouldReceive('getElementName')->andReturn("elementName{$number}");
        $elementAssignment->shouldReceive('getQuestionNumber')->andReturn($number);

        return $elementAssignment;
    }


    public function testFunctionalTest()
    {
        $questionAssignments = collect([$this->buildQuestionAssignmentMock(1), $this->buildQuestionAssignmentMock(2)]);
        $elementAssignments = collect([$this->buildElementAssignmentMock(1), $this->buildElementAssignmentMock(2)]);


        $students = factory('App\Student', 3)->make();
        $elementScores = factory('App\ElementScore', 3)->make();
        $questionScores = factory('App\QuestionScore', 3)->make();

        $examId = 1;
        $this->questionAssignmentRepository->shouldReceive('load_all_for_exam')
            ->with($examId)
            ->andReturn($questionAssignments);

        $this->elementAssignmentRepository->shouldReceive('load_element_assignments_by_question_number')
            ->with($examId, 1)
            ->andReturn($elementAssignments);
        $this->elementAssignmentRepository->shouldReceive('load_element_assignments_by_question_number')
            ->with($examId, 2)
            ->andReturn($elementAssignments);

        $elscore = factory('App\ElementScore')->make();
        $elscore->score = 4.3;

        $this->studentRepository->shouldReceive('load_students_by_exam')->with($examId)->andReturn($students);
        $this->questionScoreRepository->shouldReceive('load')->andReturn($elscore);

        $this->elementScoreRepository->shouldReceive('load')->andReturn($elscore);

        $comment = factory('App\Comment')->make();
        $comment->body = 'comment text';
        $this->commentRepository->shouldReceive('getCommentForScore')->andReturn($comment);


        $fb = new FeedbackBuilder();

        $result = $fb->buildFeedback($examId);
        $this->assertNotEmpty($result);
        $this->assertTrue(is_array($result));
        $this->assertEquals(count($students), count($fb->students), "correct number of student arrays");
    }


    /**
     * @param $elementAssignments
     * @param $student
     * @param $comments
     */
    public function buildElementScore()
    {
//        $elementAssignments, $student, &$comments
//        $elementId = $this->faker->randomNumber(3);
        $studentId = $this->faker->randomNumber(3);
        $comments = [];
        $score = $this->faker->randomFloat();

//        $this->elementAssignmentRepository->shouldReceive('load')->with()

    }


    public function testBuildOneQuestion(
        IElementAssignmentRepository $elementAssignmentRepository,
        $examId,
        $questionName,
        $questionNumber,
        $studentId,
        &$data
    ) {
//        $testArray = [];
//        $examId = $this->faker->randomNumber(3);
//        $questionNumber = $this->faker->randomDigit();
//        $questionName = $this->faker->text();
//        $studentId = $this->faker->randomNumber(9);
//
//
//        $elementAssignmentRepository = \Mockery::mock('App\Repositories\Element\IElementAssignmentRepository')
//        ->shouldReceive('load_element_assignments_by_question_number')
//        ->withArgs([$examId, $questionNumber]);
//
//        $this->object->buildOneQuestion($elementAssignmentRepository, $examId, $questionName, $questionNumber, $studentId, $testArray);
//
//        $elementAssignments = $this->elementAssignmentRepository->load_element_assignments_by_question_number($examId, $questionNumber);
//        $this->buildElementScore($elementAssignments, $studentId, $comments);
//        $data[$questionNumber] = [
//            'questionTitle' => $questionName,
//            'questionNumber' => $questionNumber,
//            'questionScore' =>
//            'comments' => $comments
//        ];

    }

    public function testBuildFeedback()
    {
//        $result = $this->object->buildFeedback($this->exam->getId());
//        $this->assertNotEmpty($result);
//        $this->assertEquals(is_array($result));
    }


    public function testBuildTopLevelContent()
    {
        $this->markTestIncomplete();
//        &$studentArray, $examName, $grade

    }

    public function testBuildQuestion()
    {
        $this->markTestIncomplete();
        //&$studentArray, $questionNumber, $questionTitle, $commentsArray
    }

}
