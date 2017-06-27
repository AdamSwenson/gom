<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 6:22 PM
 */

namespace App\Repositories\Feedback;


use App\AccessKey;
use App\Exam;
use App\Feedback;
use App\QuestionAssignment;
use App\Repositories\Element\CommentRepository;
use App\Repositories\Element\ElementAssignmentRepository;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\QuestionAssignmentRepository;
use App\Repositories\Score\ElementScoreRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Score\QuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Student\StudentRepository;
use App\Student;
use Mockery\Mock;

class FeedbackBuilderTest extends \TestCase
{

    public $exam;
    protected $object;
    protected $questionAssignmentRepository;
    protected $elementAssignmentRepository;
    protected $questionScoreRepository;
    protected $elementScoreRepository;
    protected $commentRepository;
    protected $studentRepository;
    protected $accessKeyRepository;

    public function setUp()
    {
        parent::setUp();

        $this->questionAssignmentRepository = $this->makeMock(IQuestionAssignmentRepository::class);
        $this->elementAssignmentRepository = $this->makeMock(IElementAssignmentRepository::class);
        $this->questionScoreRepository = $this->makeMock(IQuestionScoreRepository::class);
        $this->elementScoreRepository = $this->makeMock(IElementScoreRepository::class);
        $this->commentRepository = $this->makeMock(ICommentRepository::class);
        $this->studentRepository = $this->makeMock(IStudentRepository::class);
        $this->accessKeyRepository = $this->makeMock(IAccessKeyRepository::class);
        $this->object = new FeedbackBuilder();

        $this->exam  = Exam::all()->random();

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
        $exam = factory(Exam::class)->create();
        $examId = $exam->id;
        $number = 5;

        //$number = $this->faker->randomNumber();
        $this->assertEmpty($this->object->students);
        $students = factory(Student::class, $number)->make();
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


    /**
     * @test
     */
    public function functional_test_of_build_feedback()
    {
        //Prep
        $questionAssignments = collect([$this->buildQuestionAssignmentMock(1), $this->buildQuestionAssignmentMock(2)]);
        $elementAssignments = collect([$this->buildElementAssignmentMock(1), $this->buildElementAssignmentMock(2)]);

        $students = factory('App\Student', 3)->make();
        $elementScores = factory('App\ElementScore', 3)->make();
        $questionScores = factory('App\QuestionScore', 3)->make();

        $exam = factory(Exam::class)->create();
        $examId = $exam->id;
//        $examId = 1;
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
        $elscore->comment_text = $this->faker->text();

        $this->studentRepository->shouldReceive('load_students_by_exam')->with($examId)->andReturn($students);
        $this->questionScoreRepository->shouldReceive('load')->andReturn($elscore);

        $this->elementScoreRepository->shouldReceive('load')->andReturn($elscore);

        $testData = [
            [
                'questionNumber'       => 1,
                'questionName'         => 'qname',
                'questionAssignmentId' => 1,
                'questionScore'        => 89.3,
            ],
            [
                'questionNumber'       => 2,
                'questionName'         => 'qname2',
                'questionAssignmentId' => 2,
                'questionScore'        => 20.4,
            ],
        ];

        $this->questionScoreRepository
            ->shouldReceive('load_for_student_on_exam')
            ->andReturn($testData);

        $ak = AccessKey::all()->random();
        $f = Feedback::where('access_key', $ak->access_key)->first();
        if ( $f )
        {
            $f->delete();
        }
        $this->accessKeyRepository
            ->shouldReceive('createAccessKey')
            ->andReturn($ak->access_key);

        //Call
        $fb = new FeedbackBuilder();
        $result = $fb->buildFeedback($examId);

        //Check
        $this->assertNotEmpty($result);
        $this->assertTrue(is_array($result));
        $this->assertEquals(count($students), count($fb->students), "correct number of student arrays");
    }


    public function testRecompileFeedbackForStudent()
    {
        //Prep
        /*  Since we're going to be simulating recompiling feedback for
            a student once they already have an access_key, let's grab one from the db
            and use their properties */
        $f = Feedback::all()->random();
        $ak = AccessKey::where('access_key', $f->access_key)->first();
        $examId = $ak->exam_id;
        $studentId = $ak->student_id;
        $keyString = $ak->access_key;
        $student = Student::find($studentId);

        //check that loaded properly
        $this->assertInstanceOf('App\Student', $student);
        $this->assertEquals($studentId, $student->id);

        //Build mocks
        $questionAssignments = collect([$this->buildQuestionAssignmentMock(1), $this->buildQuestionAssignmentMock(2)]);
        $elementAssignments = collect([$this->buildElementAssignmentMock(1), $this->buildElementAssignmentMock(2)]);

        $this->questionAssignmentRepository->shouldReceive('load_all_for_exam')
            ->with($examId)
            ->andReturn($questionAssignments);

        $this->elementAssignmentRepository
            ->shouldReceive('load_element_assignments_by_question_number')
            ->with($examId, 1)
            ->andReturn($elementAssignments);
        $this->elementAssignmentRepository
            ->shouldReceive('load_element_assignments_by_question_number')
            ->with($examId, 2)
            ->andReturn($elementAssignments);

        $elscore = factory('App\ElementScore')->make();
        $elscore->score = 4.3;
        $elscore->comment_text = $this->faker->text();

        $this->questionScoreRepository
            ->shouldReceive('load')
            ->andReturn($elscore);
        $this->elementScoreRepository
            ->shouldReceive('load')
            ->andReturn($elscore);
        $testData = [
            [
                'questionNumber'       => 1,
                'questionName'         => 'qname',
                'questionAssignmentId' => 1,
                'questionScore'        => 89.3,
            ],
            [
                'questionNumber'       => 2,
                'questionName'         => 'qname2',
                'questionAssignmentId' => 2,
                'questionScore'        => 20.4,
            ],
        ];

        $this->questionScoreRepository
            ->shouldReceive('load_for_student_on_exam')
            ->andReturn($testData);


        $this->accessKeyRepository
            ->shouldReceive('getAccessKeyForStudent')
            ->with($examId, $studentId)
            ->andReturn($keyString);

        //Call
        $fb = new FeedbackBuilder();
        $result = $fb->recompileFeedbackForStudent($examId, $student);

        //Check
        $this->assertNotEmpty($result);
        $this->assertTrue(is_array($result));
        $this->assertEquals(1, count($fb->feedback), "correct number of feedback arrays");
        $this->assertEquals($keyString, key($fb->feedback));
    }

    /**
     * @test
     */
    public function StoreFeedback_where_new_data()
    {
        #prep
        $key = factory(AccessKey::class)->create()->access_key;
        $f = factory(Feedback::class)->make();
        $newContent = $f->content;
        $newGrade = $f->grade_display;
        $newGradeCalc = $f->grade_calc;

        #call
        $result = $this->object->storeFeedback($key, $newContent, $newGrade, $newGradeCalc);

        #check
        $this->assertTrue($result);
        $t = Feedback::where('access_key', $key)->first();
        $this->assertEquals($newContent, $t->content);
        $this->assertEquals($newGrade, $t->grade_display);
        $this->assertEquals($newGradeCalc, $t->grade_calc);
    }

    /**
     * @test
     */
    public function StoreFeedback_where_updating_existing_record()
    {
        #prep
        $existingFeedback = factory(Feedback::class)->create();
        $oldContent = $existingFeedback->content; //accessing via method so get string rep of json
        $key = $existingFeedback->access_key;
        $id = $existingFeedback->id;
        $newContent = factory(Feedback::class)->make()->content;//accessing via method so get string

        #call
        $result = $this->object->storeFeedback($key, $newContent);

        #check
//        $this->assertInstanceOf(Feedback::class, $result, "returned expected object type");
        $this->assertTrue($result);
        $t = Feedback::where('access_key', $key)->first();
        $this->assertEquals($newContent, $t->content);
        $this->assertNotEquals($oldContent, $t->content);
        $this->assertEquals($id, $t->id);

//        //Prep
//        $testFeedback = Feedback::all()->random();
//        $accessKey = $testFeedback->access_key;
//        $existingContent = $testFeedback->content;
//
//        //Call
//        $testContent = [
//            'item1' => $this->faker->text(100),
//            'item2' => $this->faker->text(100),
//            'item3' => $this->faker->text(100),
//        ];
//        $result = $this->object->storeFeedback($accessKey, $testContent);
//
//        //Check
//        $this->assertTrue($result, "update feedback returns boolean");
//
//        //New content written to db with same access key
//        $this->assertDatabaseHas('feedback', [
//            'access_key' => $accessKey,
//            'content'    => json_encode($testContent),
//        ]);
//
//        //Make sure that the old content has been replaced
//        $this->assertDatabaseMissing('feedback', [
//            'access_key' => $accessKey,
//            'content'    => json_encode($existingContent),
//        ]);
    }

    /** @test */
    public function setExamGetsId(){
        #prep
        $exam = factory(Exam::class)->create();
        $this->assertAttributeEmpty('exam', $this->object, "no exam present");

        #call
        $this->object->setExam($exam->id);

        #check
        $this->assertAttributeInstanceOf(Exam::class, 'exam', $this->object, "exam present");
        $this->assertEquals($exam->id, $this->object->exam->id, "loaded exam has correct id");
    }

    /** @test */
    public function setExamGetsObject(){
        #prep
        $exam = factory(Exam::class)->create();
        $this->assertAttributeEmpty('exam', $this->object, "no exam present");

        #call
        $this->object->setExam($exam);

        #check
        $this->assertAttributeInstanceOf(Exam::class, 'exam', $this->object, "exam present");
        $this->assertEquals($exam->id, $this->object->exam->id, "loaded exam has correct id");
    }

    /** @test */
    public function setStudentGetsId(){
        #prep
        $student = factory(Student::class)->create();
        $this->assertAttributeEmpty('student', $this->object, "no student present");

        #call
        $result = $this->object->setStudent($student->id);

        #check
        $this->assertAttributeInstanceOf(Student::class, 'student', $this->object, "student present");
        $this->assertEquals($student->id, $this->object->student->id, "loaded student has correct id");
        $this->assertInstanceOf(Student::class, $result, "student object returned");
        $this->assertEquals($student->id, $result->id, "returned object has correct id");
    }

    /** @test */
    public function setStudentGetsObject(){
        #prep
        $student = factory(Student::class)->create();
        $this->assertAttributeEmpty('student', $this->object, "no student present");

        #call
        $result = $this->object->setStudent($student);

        #check
        $this->assertAttributeInstanceOf(Student::class, 'student', $this->object, "student present");
        $this->assertEquals($student->id, $this->object->student->id, "loaded student has correct id");
        $this->assertInstanceOf(Student::class, $result, "student object returned");
        $this->assertEquals($student->id, $result->id, "returned object has correct id");
    }

}
