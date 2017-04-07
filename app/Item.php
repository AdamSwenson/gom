<?php

namespace App;

use App\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * @package App
 */
class Item extends Model
{
    /**
     * @var
     */
    public $idx = [];
    public $index;
    public $id;
    public $assignmentId;
    public $examId;
    public $name;
    public $publicName;
    public $text;
    public $maxScore;


    protected $guarded = ['user_id', 'id'];

    protected $fillable = [
        'idx',
        'index',
        'assignmentId',
        'examId',
        'name',
        'publicName',
        'text',
        'maxScore'
    ];


    public function __construct()
    {
    }


    /**
     * Updates an existing item or creates a new one
     * if none exists from a request object.
     *
     * @param Request $request
     * @return Item
     */
    static function loadItemFromRequest( Request $request )
    {

        //these are the properties of the new exam
        //which have matches in the old models
        //TODO create storage for all these properties
        $examEditable = ['id', 'name'];
        //not editable: text, number, comments

        $questionEditable = ['id'];

        $elementEditable = ['id' ];

        switch ( self::determineItemType($request) ) {

            case Exam::class:
                $id = $request->has('id') ? $request->input('id') : null;

                $term = $request->has('term') ? $request->input('term') : Carbon::now()->year;
                $year = $request->has('year') ? $request->input('year') : Carbon::now()->year;
                $name = $request->has('name') ? $request->input('name') : self::makeDefaultExamName();

                $d = ['id'=> $id, 'term' => $term, 'year' => $year, 'name' => $name];
                $item = Exam::updateOrCreate($d);
                break;

            case Element::class:
                $name = $request->has('name') ? $request->input('name') : 'Unnamed -- created: ' . Carbon::now()->toDayDateTimeString();

                $d = $request->only($elementEditable) + ['elementName' => $name];
                $item = Element::updateOrCreate($d);
                break;

            case Question::class:
                $name = $request->has('name') ? $request->input('name') : self::makeDefaultQuestionName();

                $text = $request->has('text') ? $request->input('text') : '';


                $d = $request->only($questionEditable) + ['questionName' => $name, 'questionText' => $text];
                $item = Question::updateOrCreate($d);
                break;

            default:
        }

        return $item;

    }


    /**
     * Sets the $type value from the request
     * @param ItemRequest $request
     */
    static function determineItemType( Request $request )
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
            if ( $request->input('depth' > 0) ) return Element::class;
            if ( $request->input('index') >= 1 ) return Question::class;

        }

    }


    #------------ foreign keys
    /**
     * Returns associated exams. Returns exam object collection
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments')->withPivot('question_number')->withTimestamps();
    }

    /**
     * Returns associated user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns associated exams. Returns exam object collection
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questionAssignments()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments')->withPivot('question_number')->withTimestamps();
    }

    /**
     * Returns associated scores
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function scores()
    {
        return $this->hasManyThrough('App\QuestionScore', 'App\QuestionAssignment', 'question_id',
            'question_assignment_id');
    }


    /* ----------------------------------- Defaults ----------------- */
    /**
     * @return string
     */
    protected static function makeDefaultExamName(): string
    {
        return 'Unnamed -- created: ' . Carbon::now()->toDayDateTimeString();
    }

    /**
     * @return string
     */
    protected static function makeDefaultQuestionName(): string
    {
        return 'Unnamed -- created: ' . Carbon::now()->toDayDateTimeString();
    }



}


//        //determine whether new or existing from whether an id is given
//        $id = $request->has('id') ? $request->input('id') > 0 : false;
//
//        if ( $id && $id > 0 ) {
//            //item exists, so we need to load it
//            switch ( self::determineItemType($request) ) {
//                case Exam::class:
//                $item = Exam::updateOrCreate($request->all());
//                    //lookup by id
////                    $item = Exam::find($id);
//                    break;
//                case
//                Element::class:
//                    $item = Element::updateOrCreate($request->all());
//                   // $item = Element::find($id);
//
//                    break;
//                case Question::class:
//                    $item = Question::updateOrCreate($request->all());
//              //      $item = Question::find($id);
//
//                    break;
//                default:
//            }
//        }else{
//        //item has no id or id of -1 or 0 so it is new
//
//            switch ( self::determineItemType($request) ) {
//                case Exam::class:
//                    //lookup by id
//                    $item = Exam::find($id);
//                    break;
//                case
//                Element::class:
//                    $item = Element::find($id);
//
//                    break;
//                case Question::class:
//                    $item = Question::find($id);
//
//                    break;
//                default:
//            }
//
//        }
//
//
//        //if we have an item, fill the props from the request
//        if($item){
//
//        }
//
//
//        return $item;

//
//    public function fillItem( Request $request )
//    {
//        foreach ( $this->fillable as $prop ) {
//            if ( $request->has($prop) ) {
//                $item[$prop] = $request->has($prop);
//            }
//        }
//    }
//

//
//    /**
//     * Returns true if the request concerns an element,
//     * returns false otherwise
//     * @param ItemRequest $request
//     * @return bool
//     */
//    static function isElement( Request $request )
//    {
//        //If it wasn't an exam, it was either a question or element
//        //We figure this out from the depth
//        if ( $request->input('depth') > 0 ) {
//            return true;
//        }
//
//        return false;
//    }
//
//    /**
//     * Returns true if the request concerns an exam,
//     * returns false otherwise
//     * @param ItemRequest $request
//     * @return bool
//     */
//    static function isExam( Request $request )
//    {
//        //Exams are the root element with an index of 0 and a depth of 0
//        if ( $request->input('index') == 0 && $request->input('depth') == 0 ) {
//            return true;
//        }
//        return false;
//    }
//
//
//    /**
//     * Returns true if the request concerns a question,
//     * returns false otherwise
//     * @param ItemRequest $request
//     * @return bool
//     */
//    static function isQuestion( Request $request )
//    {
//        //If it wasn't an exam, it was either a question or element
//        //We figure this out from the depth
//        if ( $request->input('index') > 0 && $request->input('depth') == 0 ) {
//            return true;
//        }
//
//        return false;
//    }

//}
