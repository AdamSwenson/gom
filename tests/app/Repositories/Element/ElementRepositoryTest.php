<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 10:19 AM
 */

namespace App\Repositories\Element;


use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\Comment;
use App\Element;

class ElementRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementRepository();

        $this->object->set_cleaner(new CleanerFactory());
        $this->element = Element::all()->random();
        $this->comment = Comment::all()->random();
    }



    public function testLoadElementById()
    {
        $result = $this->object->loadElementById($this->element->getId());
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Element', $result);
        $this->assertEquals($this->element->getId(), $result->getId());
    }

    # TODO: Add the following once exception handling has been figured out.
    //public function testLoadElementByIdExceptionIdWrongtype(){}
    //public function testLoadElementByIdExceptionIdOutOfRange(){}


    public function testCreateElement()
    {
        $elementName = $this->faker->text();
        $displayText = $this->faker->text();
        $commentText = $this->faker->text();

        $result = $this->object->createElement($elementName, $displayText, $commentText);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Element', $result);

        $this->assertEquals($elementName, $result->elementName);
        $this->assertEquals($displayText, $result->displayText);
        $this->assertEquals($commentText, $result->commentText);
    }

    # TODO: Add the following once exception handling has been figured out.
//    public function testCreateElementExceptionNameWrongType(){}
//    public function testCreateElementExceptionDisplayWrongType(){}
//    public function testCreateElementExceptionCommentWrongType(){}
//
//    public function testCreateElementExceptionNameTooLong(){}
//    public function testCreateElementExceptionDisplayTooLong(){}
//    public function testCreateElementExceptionCommentTooLong(){}


    public function testDeleteElement()
    {
        $eid = $this->element->getId();
        $result = $this->object->deleteElement($this->element->getId());
        $this->assertTrue($result);
        $this->assertEmpty(Element::find($eid));
    }


    public function testEditElement()
    {
        $eid = $this->element->getId();
        $elementName = $this->faker->text();
        $displayText = $this->faker->text();
        $commentText = $this->faker->text();

        $result = $this->object->editElement($eid, $elementName, $displayText, $commentText);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Element', $result, 'returns element');

        $altered = Element::find($eid);
        $this->assertNotEmpty($altered);
        $this->assertInstanceOf('\App\Element', $altered);

        $this->assertEquals($elementName, $altered->elementName);
        $this->assertEquals($displayText, $altered->displayText);
        $this->assertEquals($commentText, $altered->commentText);
    }


    public function testLoadCommentByElementIdAndValence()
    {
        $eid = $this->comment->element_id;
        $valence = $this->comment->valence;

        $result = $this->object->loadCommentByElementIdAndValence($eid, $valence);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\Comment', $result);
        $this->assertEquals($eid, $result->element_id);
        $this->assertEquals($valence, $result->valence);
    }

    public function testAddValencedContent()
    {
//        $elementId, $valence, $content
        $testContent = $this->faker->text(500);
        $testValence = $this->faker->randomElement(Comment::$valences);
        $eid = $this->element->id;

        $result = $this->object->addValencedContent($eid, $testValence, $testContent);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\Comment', $result);
        $this->seeInDatabase('comments', ['user_id' => 1, 'element_id' => $eid, 'valence' => $testValence, 'body' => $testContent]);

    }

    public function testAddValencedContentEmptyComment()
    {
        $testContent = '';
        $testValence = $this->faker->randomElement(Comment::$valences);
        $eid = $this->element->id;

        $result = $this->object->addValencedContent($eid, $testValence, $testContent);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\Comment', $result);
        $this->seeInDatabase('comments', ['user_id' => 1, 'element_id' => $eid, 'valence' => $testValence, 'body' => $testContent]);
    }

}
