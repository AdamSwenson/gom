<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/30/15
 * Time: 9:16 AM
 */

namespace App;


//use Illuminate\Foundation\Testing\DatabaseMigrations;

class ElementTest extends \TestCase
{
//    use DatabaseMigrations;
    protected $object;
    protected $element;

    public function setUp()
    {
        parent::setUp();

        //$this->object = new Element;
      //  $this->element = Element::all()->random();
       // $this->elementAssign = ElementAssignment::all()->random();
    }

    /**
     * Set up helper for the getters, setters, and eloquent tests
     */
    public function loginAndMakeElement()
    {
        \Auth::loginUsingId(self::$userid);
        $this->element = factory(Element::class)->create();
        $this->object = new Element;
    }

//
//    /**
//     * @test
//     * @group slowTests
//     */
//    public function setAsQuestionTask_sets_without_disturbing_other_assignments()
//    {
//        /* Completely reset and re-seed the database */
////        $this->prepareDatabase();
//        $fixture = $this->makeElementAssignmentsForQuestion(5);
//
//        //Prepare the victim.....
//        $this->object = factory(Element::class)->create();
//
//        /* At this point, the first question on exam1 1 has question_id = 1.
//            There are five element assignments.
//            element_assignment_id = 1 =>
//                element_id = 1   subtask = 1  (exam_id = 1, question_number = 1, question_id = 1, question_assignment_id = 1)
//            element_assignment_id = 2 =>
//                element_id = 2   subtask = 2  (exam_id = 1, question_number = 1, question_id = 1, question_assignment_id = 1 )
//            ...
//            element_assignment_id = 5 =>
//                element_id = 5   subtask = 5  (exam_id = 1, question_number = 1, question_id = 1, question_assignment_id = 1)
//
//            Also, the first element which is not on exam1 1 is element_id = 26.
//        */
//        $target_exam_id = $fixture['exam1']->id;
//        $element_id_to_add_to_exam = $this->object->id;
//
//        /*
//            So, we are going to take element_id = 26 and make it the new question 1 subtask 1. This should replace element_id =1
//            and not disturb any other element assignment.
//        */
//        $element_id_to_replace = $fixture['elementIds'][0];
//        $subtask_being_assigned_to = 1;
//        $question_id_being_assigned_to = $fixture['question']->id;
//
//
//        #call
//        $result = $this->object->setAsQuestionTask($target_exam_id, $question_id_being_assigned_to, $subtask_being_assigned_to);
//
//        #check
//        //Check that gave back an element object
//        $this->assertInstanceOf('App\Element', $result);
//        //And check to make sure it is the expected one
//        $this->assertEquals($element_id_to_add_to_exam, $this->object->getId());
//
//        //Make sure that the element has been written into the database
//        $this->assertDatabaseHas('element_assignments',
//                             [
//                                 'question_id' => $question_id_being_assigned_to,
//                                 'exam_id' => $target_exam_id,
//                                 'element_id' => $this->object->getId(),
//                                 'subtask' => $subtask_being_assigned_to
//                             ]);
//        //Make sure that the target element has been overwritten (in case somehow the unique constraint got altered)
//        $this->assertDatabaseMissing('element_assignments',
//                             [
//                                 'question_id' => $question_id_being_assigned_to,
//                                 'exam_id' => $target_exam_id,
//                                 'element_id' => $element_id_to_replace,
//                                 'subtask' => $subtask_being_assigned_to
//                             ]);
//
//        //Finally make sure that the other elements assigned to the question haven't been touched
//        for($i=2; $i<=5; $i++)
//        {
//            $this->assertDatabaseHas('element_assignments',
//                                 [
//                                     'question_id' => $question_id_being_assigned_to,
//                                     'exam_id' => $target_exam_id,
//                                     'element_id' => $i,
//                                     'subtask' => $i
//                                 ]);
//        }
//    }
//
//
//    /**
//     * @test
//     * @group slowTests
//     */
//    public function setAsQuestionTask_does_not_leave_duplicate_when_update_was_deletion()
//    {
//        /* Completely reset and re-seed the database */
//        //$this->prepareDatabase();
//        $fixture = $this->makeElementAssignmentsForQuestion(5);
//
//        /*
//         * In this case, we are supposing that subtask 1 was deleted.
//         * That means each of the other elements needs to move up one subtask.
//         * That is, we want to end up with
//                element_id = 2   subtask = 1  (exam_id = 1, question_number = 1, question_id = 1, question_assignment_id = 1)
//                element_id = 3   subtask = 2  (exam_id = 1, question_number = 1, question_id = 1, question_assignment_id = 1)
//                element_id = 4   subtask = 3  (exam_id = 1, question_number = 1, question_id = 1, question_assignment_id = 1)
//                element_id = 5   subtask = 4  (exam_id = 1, question_number = 1, question_id = 1, question_assignment_id = 1)
//        */
//        $target_exam_id = $fixture['exam1']->id;
//        $question_id_being_assigned_to = $fixture['question']->id;
//
//        /* Note that the tricky thing here is that we won't know coming in whether the update included just adding
//           new elements, reshuffling without deletion, or deletion; or some combination of those. So we are
//           going to assume that this function gets called successively for each element. As long as we clean up
//           any pre-existing assignments to that exam1 we should be okay.
//
//           For any but the very last subtask, the problem will be taken care of by overwriting in a subsequent call.
//           But that won't happen for the last subtask. So let's check that case to make sure everything is clean.
//           That is, we need to be particularly sure that when element_id = 5 gets recorded as subtask = 4, it isn't still assigned
//           as subtask = 5.
//         */
//        $element_id_to_reassign = $fixture['elementIds'][4];
//        $original_subtask_of_the_element = 5;
//        $subtask_being_assigned_to = 4;
//
//        //Prepare the victim.....
//        $this->object = Element::find($element_id_to_reassign);
//
//        //call
//        $result = $this->object->setAsQuestionTask($target_exam_id, $question_id_being_assigned_to, $subtask_being_assigned_to);
//
//        //Check that gave back an element object
//        $this->assertInstanceOf('App\Element', $result);
//        //And check to make sure it is the expected one
//        $this->assertEquals($element_id_to_reassign, $this->object->getId());
//
//        //Make sure that the element has been written into the new position
//        $this->assertDatabaseHas('element_assignments',
//                             [
//                                 'question_id' => $question_id_being_assigned_to,
//                                 'exam_id' => $target_exam_id,
//                                 'element_id' => $this->object->getId(),
//                                 'subtask' => $subtask_being_assigned_to
//                             ]);
//
//        //Make sure that its previous assignment was removed
//        $this->assertDatabaseMissing('element_assignments',
//                                [
//                                    'question_id' => $question_id_being_assigned_to,
//                                    'exam_id' => $target_exam_id,
//                                    'element_id' => $element_id_to_reassign,
//                                    'subtask' => $original_subtask_of_the_element
//                                ]);
//
//        //Finally make sure that the other elements assigned to the question haven't been touched
//        for($i=1; $i<=3; $i++)
//        {
//            $this->assertDatabaseHas('element_assignments',
//                                 [
//                                     'question_id' => $question_id_being_assigned_to,
//                                     'exam_id' => $target_exam_id,
//                                     'element_id' => $i,
//                                     'subtask' => $i
//                                 ]);
//        }
//    }




    public function testSetElementName()
    {
        $this->loginAndMakeElement();
        $test = $this->faker->text();
        $this->object->setElementName($test);
        $this->assertEquals($test, $this->object->elementName);
    }


    public function testSetCommentText()
    {
        $this->loginAndMakeElement();
        $test = $this->faker->text();
        $this->object->setCommentText($test);
        $this->assertEquals($test, $this->object->commentText);
    }


    public function testGetElementName()
    {
        $this->loginAndMakeElement();
        $this->assertNotEmpty($this->element->getElementName());
    }


    public function testGetCommentText()
    {
        $this->loginAndMakeElement();
        $this->assertNotEmpty($this->element->getCommentText());
    }

#----------------- foreign keys
    public function testUser()
    {
        $this->loginAndMakeElement();
        $this->assertInstanceOf('App\User', $this->element->user);
    }

//    public function testElementAssignments()
//    {
//        foreach($this->element->elementAssignments as $r)
//        $this->assertInstanceOf('App\ElementAssignment', $r);
//    }

//    public function testQuestionAssignments()
//    {
//        foreach ($this->element->questionAssignments as $r)
//        {
//            $this->assertInstanceOf('App\QuestionAssignment', $r);
//        }
//    }


//    public function testExam()
//    {
//        foreach($this->element->exam1 as $r)
//        {
//            $this->assertInstanceOf('App\ElementScore', $r);
//        }
//    }

    public function testScores()
    {        $this->loginAndMakeElement();
        foreach ($this->element->scores as $r)
        {
            $this->assertInstanceOf('App\ElementScore', $r);
        }
    }

    public function testComments()
    {        $this->loginAndMakeElement();
        foreach ($this->element->comments as $r)
        {
            $this->assertInstanceOf('App\Comment', $r);
        }
    }

//    public function testQuestions()
//    {
//        foreach($this->element->questions as $r)
//        {
//            $this->assertInstanceOf('App\Question', $r);
//        }
//    }
}
