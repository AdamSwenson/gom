<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:49 PM
 */

namespace App\Repositories\Element;


use App\Comment;
use App\ElementAssignment;
use App\Exam;
use App\Http\Controllers\helpers\assignments\AssignmentHelper;
use App\Http\Requests\ElementRequest;
use App\Question;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\QuestionAssignmentRepository;
use App\Element;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Handles db interactions for element assignments.
 *
 * TODO: Refactor so that the various methods return similar things rather than the mix of collections, stdClass, and arrays currently returned.
 *
 * @package App\Repositories\Element
 */
class ElementAssignmentRepository implements IElementAssignmentRepository
{

    public $assignments;

    /** @var  Exam Holds the exam working on */
    public $exam;

    /** @var  IQuestionAssignmentDAO */
    public $questionAssignmentDao;

    /** @var  array Ids of elements which the incoming request asks to assign */
    protected $requestIds = [];
    /** @var  array Ids of elements which were assigned prior to the request */
    protected $existingIds = [];

    /** @var  array Array of element objects */
    protected $elements = [];

    /** @var  \App\Http\Controllers\helpers\assignments\IAssignmentHelper */
    protected $helper;

    /** @var  Question The question assignments are being made to */
    protected $question;


    public function __construct()
    {
        $this->questionAssignmentDao = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
    }


    /**
     * Returns an array of Element objects
     * @param $examId
     * @param $questionNumber
     * @return array
     */
    public function load_elements($examId, $questionNumber)
    {
        $this->load_element_assignments_by_question_number($examId, $questionNumber);
        $elements = array();
        foreach ($this->assignments as $assign)
        {
            array_push($elements, $assign->element()->first());
        }

        return $elements;
    }

    /**
     * Returns collection of elementAssignment objects associated with a question on an exam.
     * @param $examId
     * @param $questionNumber
     * @return \Illuminate\Support\Collection
     */
    public function load_element_assignments_by_question_number($examId, $questionNumber)
    {
        $questionAssignment = $this->questionAssignmentDao->load($examId, $questionNumber);

        if (empty($questionAssignment))
        {
            //TODO: Add error handling
        }
        $this->assignments = ElementAssignment::where('exam_id', $examId)
            ->where('question_id', $questionAssignment->question_id)
            ->get();

        return $this->assignments;
    }

    /**
     * Loads the element assignment object for an element on an exam
     * @param $examId
     * @param $elementId
     */
    public function load_element_assignment_by_element($examId, $elementId)
    {
        return ElementAssignment::where('exam_id', $examId)->where('element_id', $elementId)->first();
    }

    /**
     * Loads all elements on an exam. By default, will return a laravel collection of ElementAssignment objects
     *
     * If $returnArray is set to true, these will be returned in an array of StdClass objects. Each object will have the properties:
     *      element_assignmentId,
     *      question_id,
     *      element_id,
     *      subtask
     *
     * The objects will be in ascending order by question number and subtask
     * For example: [
     *      question 1 subtask 1,
     *      question 1 subtask 2,
     *      ....
     *      question 2 subtask 1,
     *      ....
     *      question 3 subtask 1
     *      ....
     *      ]
     *
     * @param integer $examId
     * @param bool $returnArray
     * @return \Illuminate\Support\Collection|array
     */
    public function load_by_exam($examId, $returnArray = false)
    {
        $query = <<<MYSQL
            SELECT ea.id AS element_assignment_id, ea.question_id, ea.element_id, ea.subtask
            FROM element_assignments ea
            INNER JOIN question_assignments qa ON qa.question_id = ea.question_id AND qa.exam_id = ea.exam_id
            WHERE ea.exam_id = :examId
            ORDER BY qa.question_number, ea.subtask
MYSQL;
        $values = ['examId' => $examId];
        $result = \DB::select($query, $values);
        if ($returnArray === true)
        {
            return $result;
        }
        $objects = [];
        foreach ($result as $r)
        {
            $ea = new ElementAssignment();
            $ea->id = $r->element_assignment_id;
            $ea->question_id = $r->question_id;
            $ea->element_id = $r->element_id;
            $ea->exam_id = $examId;
            $ea->subtask = $r->subtask;
            array_push($objects, $ea);
        }

        return collect($objects);
    }

    /**
     * Record the assignment of an element to an assigned question as a particular subtask
     * @param $examId
     * @param $questionId
     * @param $elementId
     * @param $subtask
     * @return Element
     */
    public function record($examId, $questionId, $elementId, $subtask)
    {
        $element = Element::findOrFail($elementId);
        return $element->setAsQuestionTask($examId, $questionId, $subtask);
    }


    /**
     * When recording an element assignment, we need to do a bunch more stuff if
     * the element was already assigned on the exam. This checks if it is already assigned
     * so that other methods can follow the appropriate path.
     *
     * It will return false if the element is not yet assigned. If it has been assigned,
     * this will return the assignment as an ElementAssignment object.
     *
     * @param integer $examId
     * @param integer $elementId
     * @return ElementAssignment|bool
     */
    protected function isElementAlreadyAssignedOnThisExam($examId, $elementId)
    {
        $ea = ElementAssignment::where('exam_id', $examId)->where('element_id', $elementId)->first();
        if (empty($ea))
        {
            return false;
        } else
        {
            return $ea;
        }
    }

    /**
     * When an element is deleted from an exam, the other elements associated with the question will need to be reordered.
     * This returns a collection of elementAssignment objects for the elements which need to be reordered.
     * @param integer $examId
     * @param integer $questionId
     * @param integer $subtaskOfElementBeingDeleted
     * @return bool
     */
    public function reorderElementsToMaintainSubtaskConsistency($examId, $questionId, $subtaskOfElementBeingDeleted)
    {

        $assignments = ElementAssignment::where('exam_id', $examId)
            ->where('question_id', $questionId)
            ->where('subtask', '>', $subtaskOfElementBeingDeleted)
            ->orderBy('subtask')
            ->get();

        /*
        * If $assignments is empty, the element being deleted was set as the last subtask, so
        * we don't need to do anything else. But if it is empty, we need to go through and
        * reduce the assigned subtask by one for each of the elements whose subtask was greater
        * than the subtask of the element being deleted.
        */
        if (!empty($assignments))
        {
            //Do reordering
            foreach ($assignments as $assign)
            {
                $assign->subtask = $assign->subtask - 1;
                $assign->update();
            }
        }
        return true;
    }



    /* ------------------------------------------------------------------------------------------------- */
    /**
     * Handles the request that comes to ElementController->updateAll. Had to be done here
     * because cannot act on each element one by one without creating problems for existing scores.
     *
     * @param Exam $exam
     * @param Question $question
     * @param ElementRequest $request
     * @throws Exception
     */
    public function updateAll(Exam $exam, Question $question, ElementRequest $request)
    {
        $this->exam = $exam;
        $this->question = $question;

        //Load and update element objects or make new ones. Hold in the elements array
        $this->makeAndLoad($request);

        //Load array of elementIds currently used in element assignments for the exam and question
        $this->getExistingElementIds($this->exam->getId(), $this->question->getId());

        //Record assignments
        $this->helper = app()->make('App\Http\Controllers\helpers\assignments\IAssignmentHelper');

        switch ($this->helper->determineCase($this->existingIds, $this->requestIds))
        {
            case AssignmentHelper::CASE_NO_CHANGE:
                //do nothing
                break;

            case AssignmentHelper::CASE_PURE_DELETION:
                //delete all the existing assignments (should cascade to delete scores)
                $this->deleteElements();
                break;

            case AssignmentHelper::CASE_PURE_ADDITION:
                //add new assignments (no effect on scores)
                foreach ($this->elements as $e)
                {
                    $e[1]->setAsQuestionTask($this->exam->getId(), $this->question->getId(), $e[0]);
                    $e[1]->save();
                }
                break;

            case AssignmentHelper::CASE_IMPURE:
                //Some potentially confusing mix of additions, deletions, and reordering has happened
                $this->handleImpure();
                break;

            default:
                throw new Exception('Case not covered by AssignmentHelper');
        }
    }

    /**
     * Deletes any questions (not just their assignments) which
     * are in the list of deletedIds on the helper
     */
    public function deleteElements()
    {
        if (count($this->helper->deletedIds) > 0)
        {
            Element::destroy($this->helper->deletedIds);
        }
    }

    /**
     * There are a bunch of possible combinations of addition, deletion, and reordering which
     * might have happened. We can't change the assignment ids for existing assignments because
     * we will lose the associated scores. This handles those cases.
     */
    public function handleImpure()
    {
        if( !empty($this->exam) && !empty($this->question))
        {
            /*
             * This all needs to be inside the transaction. If, for example, it fails before the cleanup step,
             * the user will be very confused by having questions 6-10 when she thought she had 1-5.
             */
            DB::transaction(function ()
            {

                /* If an element was deleted, no need for fancy assignment nonsense. Just delete
                   that bad boy and let it cascade to assignments and scores.*/
                $this->deleteElements();

                //Get the highest subtask that has been used on the exam for the question
                $newSort = $this->getMaxSubtask($this->exam->getId(), $this->question->getId());

                /* There are a bunch of possible combinations of addition, deletion, and reordering which
                   might have happened. We can't change the assignment ids for existing assignments because
                   we will lose the associated scores. So we're going to temporarily assign each subtask a number
                   that is higher than any existing subtask (we will insert new elements and update the subtask of
                   already assigned elements).*/
                foreach ($this->requestIds as $id)
                {
                    //this is the ordinal value which temporarily replaces the subtask
                    $newSort += 1;
                    $query = <<<MYSQL
             INSERT INTO element_assignments (exam_id, question_id, element_id, subtask, created_at, updated_at)
            VALUES (:examId, :questionId, :elementId, :subtask, NOW(), NOW())
            ON DUPLICATE KEY UPDATE subtask = :subtask2, updated_at = NOW();
MYSQL;
                    $values = [
                        'examId' => $this->exam->getId(),
                        'questionId' => $this->question->getId(),
                        'elementId' => $id,
                        'subtask' => $newSort,
                        'subtask2' => $newSort
                    ];
                    DB::update($query, $values);
                }

                /*
                 * Now that all the elements are in order in the element_assignments table, we need to
                 * give them the correct subtasks (i.e., so that the order starts at 1).
                 *
                 * So we load all element assignments for the exam/question and then update their subtasks
                 * accordingly.
                 */
                $assigns = ElementAssignment::where('exam_id', $this->exam->getId())
                    ->where('question_id', $this->question->getId())
                    ->orderBy('subtask')
                    ->get();
                for ($i = 0; $i < count($assigns); $i++)
                {
                    $assigns[$i]->subtask = $i + 1;
                    $assigns[$i]->update();
                }
            });
        }
    }

    /**
     * Loads the highest question_number that has been assigned on the exam.
     *
     * @param integer $examId
     * @param integer $questionId
     * @return int mixed
     */
    public function getMaxSubtask($examId, $questionId)
    {
        $query = <<<MYSQL
            SELECT MAX(subtask) AS max
            FROM element_assignments
            WHERE exam_id = :examId AND question_id = :questionId
MYSQL;
        $values = ['examId' => $examId, 'questionId' => $questionId];
        $result = \DB::select($query, $values);

        return $result[0]->max;
    }

    /**
     * Retrieves ths elementIds for elements that have already been
     * assigned on this exam and stores them in $this->existingIds
     * @param integer $examId
     * @param integer $questionId
     */
    public function getExistingElementIds($examId, $questionId)
    {
        $query = <<<MYSQL
            SELECT element_id
            FROM element_assignments
            WHERE exam_id = :examId AND question_id = :questionId
            ORDER BY subtask
MYSQL;
        $values = ['examId' => $examId, 'questionId' => $questionId];
        foreach (\DB::select($query, $values) as $obj)
        {
            $this->existingIds[] = $obj->element_id;
        }
    }

    /**
     * Processes the request and makes new elements if the id is 0 and
     * loads existing elements (updating them if necessary).
     *
     * Stores all the elements in the elements array as
     * an array with the form: [subtask, elementObject].
     *
     * Also stores all ids from the incoming request (including newly created elements) in
     * ascending order of subtask (starting at 1) in $requestIds.
     *
     * @param ElementRequest $request
     */
    public function makeAndLoad(ElementRequest $request)
    {
        $elementDao = app()->make('App\Repositories\Element\IElementRepository');

        $numValences = count(Comment::$valences);

        //  Update elements and create new elements as necessary
        $i = 1;
        while ($request->input('elementName' . $i))
        {
            $elementId = $request->input('elementId' . $i);
            $elementName = $request->input('elementName' . $i);
            $elementText = $request->input('elementText' . $i);
            $displayText = ''; // We're not using the 'displayText' parameter at this time.

            // New elements arrive with id == 0
            if ($elementId == 0)
            {
                // Add new Elements
                $element = $elementDao->createElement($elementName, $displayText, $elementText);
            } else
            {
                // Update existing
                $element = $elementDao->editElement($elementId, $elementName, $displayText, $elementText);
            }
            //Store the element and its order for assignment
            $this->elements[] = [$i, $element];
            //Store the id of the element
            $this->requestIds[] = $element->getId();

            // Loop through valences and add / edit comments. If the valence is empty, use the stock comment (element text)
            for ($j = 0; $j < $numValences; $j++)
            {
                $valenceComment = $request->input('e' . $i . 'valence' . $j);
                if (empty($valenceComment))
                {
                    $valenceComment = $elementText;
                }
                $elementDao->addValencedContent($element->getId(), $j, $valenceComment);
            }
            $i++;
        }
    }

}