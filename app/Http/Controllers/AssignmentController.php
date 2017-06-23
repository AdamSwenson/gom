<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Exam;
use App\Item;
use App\Repositories\Assignment\IAssignmentRepository;
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
     * Expects incoming order to have
     *      Node = {
     *              data or id: id, //the item id of the question or element
     *              parent: id //the item id of this item's parent
     *              children: []
     *       }
     * @param Exam $exam
     * @param Request $request
     */
    public function handleStore( Exam $exam, Request $request )
    {
        //expected format of incoming is a list of nodes
        // with the form


//todo add check so don't start if no ordering
        $requestRoot = $request->has('order') ? $request->input('order') : false;


//        $assignmentTree = isset($exam->assignment->id) ? $exam->assignment : $exam->assignment()->save(Assignment::create());

        //we will want to wrap this in a transaction
        //in case something goes wrong
        $exam->resetAssignments();
        $serverRoot = $exam->assignment;

        if ( sizeof($requestRoot['children']) > 0 ) {
            //call recursively
            $this->recursiveStore($requestRoot, $serverRoot);
        }

    }

    public function recursiveStore( $requestRoot, $serverRoot )
    {
        foreach ( $requestRoot['children'] as $child ) {
            //make an assignment out of an incoming child
            $n = Assignment::create(['item_id' => $child['data'], 'parent_id' => $child['parent']]);
            //add a child to the server root and return the child, renaming it as server root
            $serverRoot = $serverRoot->addChild($n, null, true);
            $serverRoot->save();
            if ( sizeof($child['children']) > 0 ) {
                //run recursively
                $this->recursiveStore($child, $serverRoot);
            }
        }
    }


    public
    function getTreeForExam( Exam $exam )
    {
        $tree = Assignment::where(['item_id', $exam->id])->get();
        return $tree->filter(function ( $key, $value ) {
            if ( $value->isRoot() ) return $value;
        });
        return false;
    }

    /**
     * Creates or updates the stored map from a map
     * sent by the client
     *
     * @param Exam $exam
     * @param  \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function store( Exam $exam, Request $request )
    {

        $assignmentDao = app()->make(IAssignmentRepository::class);
        $assignmentDao->processIncoming($exam, $request->input('order'));
        $assignments = [];
        $assignments[] = $exam->assignment;
        $assignments[] = $exam->assignment->getChildren();
        return $assignments;
        //return $this->sendAjaxSuccess();
    }

    //expected format of incoming is a list of nodes
    // with the form
    /*
        Node = {
            id: id, //the item id of the question or element
            parent: id //the item id of this item's parent
            children: []
        }
*/
//        $exam->resetAssignments();
//
//        foreach ( collect($request->input('order'))->sortBy('parentId') as $record ) {
//            if ( $record['itemId'] !== -1 ) {
//
//                //find the parent
//                $item = Item::where('id', $record['itemId'])->first();
//                $parentItem = Item::where('id', $record['parentId'])->first();
//                $depth = $record['itemOrder'];
//
//                //we need the assignment id of the parent
//                //to link them, so get the parent assignment
//                $parentAssign = Assignment::firstOrCreate(['exam_id'=> $exam->id,
//                    'item_id' => $parentItem->id]);
//
//                $exam->assignment()->create([
//                    'item_id' => $item->id,
//                    'parent_id' => $parentAssign->id,
//                    'position' => $depth
//                ]);
//
//            }
//            $p = Assignment::where('item_id', $record['parentId'])
//                ->where('exam_id', $exam->id)
//                ->first();
//            $a = Assignment::create([
//                'item_id' => $record['itemId'],
//                'real_depth' => $record['itemOrder'],
//                'exam_id' =>$exam->id
//            ]);
//            $p->addChild($a);

//todo add check so don't start if no ordering
//        $requestRoot = $request->has('order') ? $request->input('order') : false;


//        $assignmentTree = isset($exam->assignment->id) ? $exam->assignment : $exam->assignment()->save(Assignment::create());

    //we will want to wrap this in a transaction
    //in case something goes wrong
//    $exam->resetAssignments();
//    $serverRoot = $exam->assignment;
//
//    if ( sizeof($requestRoot['children']) > 0 ) {
//        //update
//        function rec( $requestRoot, $serverRoot )
//        {
//            foreach ( $requestRoot['children'] as $child ) {
//                //make an assignment out of an incoming child
//                $n = Assignment::create(['item_id' => $child['data'], 'parent_id' => $child['parent']]);
//
////                        $n = Assignment::create(['item_id' => $child['id'], 'parent_id' => $child['parent']]);
//                //add a child to the server root and return the child, renaming it as server root
//                $serverRoot = $serverRoot->addChild($n, null, true);
//                $serverRoot->save();
//                if ( sizeof($child['children']) > 0 ) {
//                    //run recursively
//                    rec($child, $serverRoot);
//                }
//            }
//        }
//
//        //call recursively
//        rec($requestRoot, $serverRoot);
//
//
//    }
//}

//                }
//
//            }
//    }
//        $tree = $this->getTreeForExam($exam);
//        if ( empty($tree) ) {
//            $tree = Assignment::create(['item_id' => $exam->id])->makeRoot(0);
//        }
//
//        //See if an assignment tree exists for the exam
//        $tree = Assignment::where(['item_id', $exam->id])->get();
//        $tree->filter(function ( $key, $value ) {
//            if ( $value->isRoot() ) return $value;
//        });
//
//        $out = ['data' => $exam->id, 'children' => [], 'parent' => $exam->id];
//        $assignmentTree = Assignment::where(['item_id', $exam->id])->get();
//        if ( $assignmentTree->hasChildren() ) {
//            $children = $assignmentTree->getChildren();
//            foreach ( $children as $child ) {
//
//
//                //Probably want to do this breadth first and work from the top down.
//                //That will allow us to infer numberings
//
//                //start by creating a queue of nodes to work on
//                $queue = [];
//
//                //We are going to want  generic item assignment storage class
//                //
//
//
////        Separating the item data from the positional/assignment info
////    * lets this be separated off into a job if we want...
////     *
//                //this should probably be a job
//                //it can run async. The client doesn't really need to know what's
//                //going on as long as the server catches up.
//
//                if ( $request->has('order') ) {
//                    $existingIds = $this->questionAssignmentDao->updateItemOrder($exam, $request->input('order'));
//
//                    return $existingIds;
//                }
//            }

    /**
     * Display the specified resource.
     *
     * @param Exam $exam
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public
    function show( Exam $exam )
    {
        $out = ['data' => $exam->id, 'children' => [], 'parent' => $exam->id];
        $assignmentTree = Assignment::where(['item_id', $exam->id])->get();
        if ( $assignmentTree->hasChildren() ) {
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
    public
    function edit( $id )
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
    public
    function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy( $id )
    {
        //
    }
}
