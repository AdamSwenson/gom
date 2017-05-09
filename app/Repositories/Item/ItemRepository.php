<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/8/17
 * Time: 5:51 PM
 */

namespace App\Repositories\Item;

use App\Element;
use App\ElementScore;
use App\Exam;
use App\GradingTime;
use App\Http\Controllers\ItemController;
use App\Http\Requests\ItemRequest;
use App\Item;
use App\Question;
use App\QuestionAssignment;
use App\QuestionScore;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Student;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;


/**
 * Class ItemRepository
 * Helps with the tasks executed by ItemController
 * @package App\Repositories\Item
 */
class ItemRepository implements IItemRepository
{

    /**
     * @param ItemRequest $request
     * @return Item|array
     */
    public function handleStoreAndUpdate( ItemRequest $request )
    {
        //This will create the item if it didn't exist and
        //update it otherwise.
        $item = $this->itemRepository->loadItemFromRequest($request);

        //Now we do anything specific based on
        //the kind of OG model the item represents.
        switch ( $item ) {

            case $item instanceof Question:
                return $this->handleQuestionStoreAndUpdate($request, $item);
                break;

            case $item instanceof Element:
                break;

            case $item instanceof Exam:
                $this->dispatch(new UpdateAllStoredExamStats());
                return $item;
                break;
            default:
                //if there was nothing special to do
                //or no item was created, fall through
        }
        return $item;
    }


    /**
     * Sets the $type value from the request
     * @param ItemRequest|Request $request
     * @return string
     */
    public function determineItemType( Request $request )
    {
        if ( $request->has('idx') ) {
            //newest version
            //check the new style index (idx) first
            $idx = $request->has('idx') ? $request->input('idx') : false;

            if ( count($idx) > 1 ) return Element::class;

            if ( $idx[0] === 0 ) return Exam::class;

            if ( $idx[0] >= 1 ) return Question::class;

        } elseif ( $request->has('depth') ) {
            //The request will be coming in with potentially a few
            //of the item fields filled in. However, we are only concerned with
            //figuring out what kind of item is being requested and its relationships,
            //and then creating those and returning the relevant ids so that
            //they can be set on the client
            if ( $request->input('index') === 0 ) return Exam::class;
            if ( $request->input('depth') > 0 ) return Element::class;
            if ( $request->input('index') >= 1 ) return Question::class;
        }
    }


    /**
     * Updates an existing item or creates a new one
     * if none exists from a request object.
     *
     * @param Request $request
     * @return Item
     */
    public function loadItemFromRequest( Request $request )
    {

        //these are the properties of the new exam
        //which have matches in the old models
        //TODO create storage for all these properties
        $examEditable = ['id', 'name'];
        //not editable: text, number, comments

        $id = $request->has('id') ? $request->input('id') : null;

        switch ( self::determineItemType($request) ) {

            case Exam::class:
                $item = $this->createExamFromRequest($request, $id);
                break;

            case Element::class:
                $item = $this->createElementFromRequest($request, $id);
                break;

            case Question::class:
                $item = $this->createQuestionFromRequest($request, $id);
                break;

            default:
        }
        if ( isset($item) ) {
            $item->save();
            return $item;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createExamFromRequest( Request $request, $id )
    {
        $item = Exam::firstOrCreate(['id' => $id]);
        $item->term = $request->has('term') ? $request->input('term') : Carbon::now()->year;
        $item->year = $request->has('year') ? $request->input('year') : Carbon::now()->year;
        $item->name = $request->has('name') ? $request->input('name') : Item::makeDefaultExamName();
        return $item;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createElementFromRequest( Request $request, $id )
    {
        $item = Element::firstOrCreate(['id' => $id]);
        $item->elementName = $request->has('name') ? $request->input('name') : Item::makeDefaultQuestionName();
        $item->displayText = $request->has('text') ? $request->input('text') : '';

        $item->max_score = $request->has('maxScore') ? $request->input('maxScore') : '';
        return $item;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createQuestionFromRequest( Request $request, $id )
    {
        $item = Question::firstOrCreate(['id' => $id]);
        $item->questionName = $request->has('name') ? $request->input('name') : Item::makeDefaultQuestionName();
        $item->questionText = $request->has('text') ? $request->input('text') : '';
        $item->max_score = $request->has('maxScore') ? $request->input('maxScore') : '';
        return $item;
    }

    /**
     * @param ItemRequest $request
     * @param $item
     * @return mixed
     */
    public function handleQuestionStoreAndUpdate( ItemRequest $request, $item )
    {
        $questionAssignmentDao = app()->make(IQuestionAssignmentRepository::class);

        if ( !$request->has('examId') ) {
            //stop here if no exam id was sent
            return $item;
        }

        //translate the idx into the OG question number
        $questionNumber = $request->has('idx') ? $request->input('idx')[0] : $request->input('index');

        //now we need to make sure the associations are taken care of
        //that is, we need to map the idx from the $request to the
        //question and element assignments
        //associate it with the exam
        $assignment = $questionAssignmentDao->record($request->input('examId'), $item->id, $questionNumber);

        //store the question assignment id in the item
        $item->questionAssignment = $assignment;

        //give it back
        return $item;
    }


}