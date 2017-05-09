<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/8/17
 * Time: 5:52 PM
 */

namespace App\Repositories\Item;

use App\ElementScore;
use App\Exam;
use App\GradingTime;
use App\Http\Controllers\ItemController;
use App\Http\Requests\ItemRequest;
use App\Question;
use App\QuestionAssignment;
use App\QuestionScore;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Student;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;


use App\Element;

class ItemRepositoryTest extends \TestCase
{

    public $request;
    public $dao;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->dao = $this->createMock(IQuestionAssignmentRepository::class);
        $this->object = new ItemRepository;
        $this->request = new ItemRequest();
    }

    /**** --------------------- Determine item type -------------- ****/

    /** @test */
    public function determineItemTypeForElementIdx()
    {
        $idx = [Factory::create()->randomDigit(), Factory::create()->randomDigit()];
        $this->request['idx'] = $idx;
        $result = $this->object->determineItemType($this->request);
        $this->assertEquals(Element::class, $result);
    }

    /** @test */
    public function determineItemTypeForQuestionIdx()
    {
        $this->request['idx'] = [Factory::create()->randomNumber(2)];
        $result = $this->object->determineItemType($this->request);
        $this->assertEquals(Question::class, $result);
    }


    /** @test */
    public function determineItemTypeForExamIdx()
    {
        $this->request['idx'] = [0];
        $result = $this->object->determineItemType($this->request);
        $this->assertEquals(Exam::class, $result);
    }

    /** @test */
    public function determineItemTypeIdxProblemCases()
    {//todo
    }

    /** @test */
    public function determineItemTypeForElementByDepth()
    {
        $this->request['depth'] = Factory::create()->randomNumber(2);
        $result = $this->object->determineItemType($this->request);
        $this->assertEquals(Element::class, $result);
    }

    /** @test */
    public function determineItemTypeForQuestionByDepth()
    {
        $this->request['depth'] = 0;
        $this->request['index'] = Factory::create()->randomNumber(2);
        $result = $this->object->determineItemType($this->request);
        $this->assertEquals(Question::class, $result);
    }


    /** @test */
    public function determineItemTypeForExamByDepth()
    {
        $this->request['depth'] = 0;
        $this->request['index'] = 0;
        $result = $this->object->determineItemType($this->request);
        $this->assertEquals(Exam::class, $result);
    }

    /** @test */
    public function determineItemTypeByDepthProblemCases()
    {
        //@todo
    }


    /**** --------------------- load item from request -------------- ****/
    /** @test */
    public function createExamFromRequest()
    {
        $existingExam = \factory(Exam::class)->create();
        $examId = $existingExam->id + 1;
        $this->request['term'] = 'term';
        $this->request['year'] = Factory::create()->year;
        $this->request['name'] = Factory::create()->company;

        $result = $this->object->createExamFromRequest($this->request, $examId);
        $this->assertInstanceOf(Exam::class, $result);
        $this->assertEquals($examId, $result->id);
        $this->assertEquals($this->request->term, $result->term);
    }

    /** @test */
    public function createElementFromRequest()
    {
        $exam = \factory(Exam::class)->create();
        $this->request['name'] = Factory::create()->company;
        $this->request['text'] = Factory::create()->word;
        $this->request['maxScore'] = Factory::create()->randomNumber();

        $result = $this->object->createElementFromRequest($this->request, $exam->id);
        $this->assertInstanceOf(Element::class, $result);
        $this->assertEquals($this->request->name, $result->elementName);
        $this->assertEquals($this->request->text, $result->displayText);
        $this->assertEquals($this->request->maxScore, $result->max_score);
    }

    public function createQuestionFromRequest()
    {
        $exam = \factory(Exam::class)->create();
        $this->request['name'] = Factory::create()->company;
        $this->request['text'] = Factory::create()->word;
        $this->request['maxScore'] = Factory::create()->randomNumber();

        $result = $this->object->createQuestionFromRequest($this->request, $exam->id);
        $this->assertInstanceOf(Question::class, $result);
        $this->assertEquals($this->request->name, $result->questionName);
        $this->assertEquals($this->request->text, $result->questionText);
        $this->assertEquals($this->request->maxScore, $result->max_score);
    }

    public function loadItemFromRequestExam()
    {
        $existingExam = \factory(Exam::class)->create();
        $this->request['id'] = $existingExam->id;
        $this->request['idx'] = [0];
        $this->request['term'] = 'term';
        $this->request['year'] = Factory::create()->year;
        $this->request['name'] = Factory::create()->company;
        $result = $this->object->loadItemFromRequest($this->request);
        $this->assertInstanceOf(Exam::class, $result);
        $this->assertEquals($existingExam->id, $result->id);
        $this->assertEquals($this->request->term, $result->term);
    }


    public function loadItemFromRequestQuestion()
    {
        $this->request['idx'] = [Factory::create()->randomNumber(2)];
        $this->request['name'] = Factory::create()->company;
        $this->request['text'] = Factory::create()->word;
        $this->request['maxScore'] = Factory::create()->randomNumber();

        $result = $this->object->loadItemFromRequest($this->request);
        $this->assertInstanceOf(Question::class, $result);
        $this->assertEquals($this->request->name, $result->questionName);
        $this->assertEquals($this->request->text, $result->questionText);
        $this->assertEquals($this->request->maxScore, $result->max_score);
    }


    public function loadItemFromRequestElement()
    {
        $idx = [Factory::create()->randomDigit(), Factory::create()->randomDigit()];
        $this->request['idx'] = $idx;
        $this->request['name'] = Factory::create()->company;
        $this->request['text'] = Factory::create()->word;
        $this->request['maxScore'] = Factory::create()->randomNumber();

        $result = $this->object->loadItemFromRequest($this->request);
        $this->assertInstanceOf(Element::class, $result);
        $this->assertEquals($this->request->name, $result->elementName);
        $this->assertEquals($this->request->text, $result->displayText);
        $this->assertEquals($this->request->maxScore, $result->max_score);
    }

    //-------------------------- question score update ----------------------

    /** @test */
    public function handleQuestionStoreAndUpdateIdxCase()
    {
        $question = \factory(Question::class)->create();
        $examId = Factory::create()->randomNumber();
        $this->request['idx'] = [Factory::create()->randomNumber()];
        //   $dao = $this->createMock(IQuestionAssignmentRepository::class);
        $this->dao->shouldReceive('record')
            ->with([$examId, $question->id, $this->request->idx])
            ->andReturn($question);

        $result = $this->object->handleQuestionStoreAndUpdate($this->request, $question);
        $this->assertEquals($question, $result);
    }


    /** @test */
    public function handleQuestionStoreAndUpdateIndexCase()
    {
        $question = \factory(Question::class)->create();
        $examId = Factory::create()->randomNumber();
        $this->request['index'] = [Factory::create()->randomNumber()];
        //   $dao = $this->createMock(IQuestionAssignmentRepository::class);
        $this->dao->shouldReceive('record')
            ->with([$examId, $question->id, $this->request->index])
            ->andReturn($question);

        $result = $this->object->handleQuestionStoreAndUpdate($this->request, $question);
        $this->assertEquals($question, $result);
    }


    /** @test */
    public function handleQuestionStoreAndUpdateWhereNoExamIdSet()
    {
        $question = \factory(Question::class)->create();
        $result = $this->object->handleQuestionStoreAndUpdate($this->request, $question);
        $this->assertEquals($question, $result); //nothing was done to it because no exam id
    }

}
