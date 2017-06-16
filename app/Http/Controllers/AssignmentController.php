<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Exam;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Item\IItemRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Student\IStudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AssignmentController
 *
 * This handles all alterations to the assignment of
 * questions and elements to exams and each other.
 *
 * @package App\Http\Controllers
 */
class AssignmentController extends Controller
{

    /**@var IExamRepository */
    protected $examDao;
    /**@var IQuestionRepository */
    protected $questionDao;
    /** @var IQuestionAssignmentRepository */
    protected $questionAssignmentDao;
    protected $questions;
    protected $requestIds;
    /** @var IStudentRepository */
    protected $studentDao;
    /** @var IElementRepository */
    protected $elementDao;
    /** @var IElementAssignmentRepository */
    protected $elementAssignmentDao;
    /** @var IItemRepository */
    protected $itemRepository;

    public function __construct(
        IExamRepository $examDao,
        IElementRepository $elementDao,
        IElementAssignmentRepository $elementAssignmentDao,
        IQuestionAssignmentRepository $questionAssignmentDao,
        IStudentRepository $studentDao,
        IQuestionRepository $questionDao,
        IItemRepository $itemRepository
    )
    {
        //dev
        Auth::loginUsingId(1);

//        $this->middleware('auth');
        $this->examDao = $examDao;
        $this->questionAssignmentDao = $questionAssignmentDao;
        $this->studentDao = $studentDao;
        $this->questionDao = $questionDao;
        $this->elementDao = $elementDao;
        $this->elementAssignmentDao = $elementAssignmentDao;
        $this->itemRepository = $itemRepository;
    }

    /*

        public function traverseDF ( $root, $callback )
        {
        // this is a recurse and immediately-invoking function
        function recurse( $currentNode ) {
        // while(stillLooking) {
        // step 2
        for ($i = 0; $i < size($currentNode.children); $i++)
        {
            if ( callback( $currentNode ) ) {
                return $currentNode;
            } else {

                // step 3
                recurse( $currentNode.children[ i ] );
            }

        }
            // }
            // window.console.log( 'orderings', 'recurse', 47, callback(currentNode));
            // step 4
            if ( $callback( $currentNode ) ) {
                // window.console.log( 'orderings', 'recurse', 50, 'FOUND IT!', currentNode );
                $stillLooking = false;
                return currentNode;
            }

            // step 1
        })( root );

    */

//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }


    /**
     * Creates or updates the stored map from a map
     * sent by the client
     *
     * @param Exam $exam
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Exam $exam, Request $request )
    {
        //expected format of incoming is a list of nodes
        // with the form
        /*
            Node = {
                id: id, //the item id of the question or element
                parent: id //the item id of this item's parent
                children: []
            }
    */


        //Probably want to do this breadth first and work from the top down.
        //That will allow us to infer numberings

        //start by creating a queue of nodes to work on
        $queue = [];

        //We are going to want  generic item assignment storage class
        //


//        Separating the item data from the positional/assignment info
//    * lets this be separated off into a job if we want...
//     *
        //this should probably be a job
        //it can run async. The client doesn't really need to know what's
        //going on as long as the server catches up.

        if ( $request->has('order') ) {
            $existingIds = $this->questionAssignmentDao->updateItemOrder($exam, $request->input('order'));

            return $existingIds;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Exam $exam
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show( Exam $exam )
    {
        $out = ['data' => $exam->id, 'children' => [], 'parent' => $exam->id];
        $assignmentTree = Assignment::where(['item_id', $exam->id])->get();
        if($assignmentTree->hasChildren()) {
            $children = $assignmentTree->getChildren();
            foreach ( $children as $child ) {

            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        //
    }
}
