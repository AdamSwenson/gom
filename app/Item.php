<?php

namespace App;

use App\Http\Requests\Request;
use App\Models\NewGom\ItemScore;
use App\Models\NewGom\Note;
use App\Models\NewGom\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 * @package App
 */
class Item extends BaseModel
{

    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $guarded = ['user_id', 'id'];

    protected $casts = [
        'settings' => 'array',
        'name' => 'string',
        'displayText' => 'string',
        'commentText' => 'string',
        'text' => 'string',
        'max_score' => 'float'];

    protected $fillable = [
        'name',
        'displayText',
        'commentText',
        'settings',
        'text',
        'max_score',
        'counts_in_total'
    ];
//
//    public function __get( $key )
//    {
//        if ( $key === 'maxScore' ) {
//            return $this->max_score;
//        }
//
//    }
//
//    public function __set( $key, $value )
//    {
//        if ( $key === 'maxScore' ) {
//            $this->max_score = $value;
//        }
//
//    }

    /**
     * Returns false if the score is not to influence the overall grade,
     * todo This will be fleshed out in GOM-347
     * @returns {boolean}
     */
    public function countsTowardTotalScore()
    {
        return $this->attributes['counts_in_total'];
    }




    #------------ foreign keys

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function comments()
    {
        return $this->hasMany(ItemComment::class);
    }

    /**
     *
     * Returns associated exams. Returns exam object collection
     * @todo Update this to reflect that an exam is a special friend of one item
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exams()
    {
        return $this->hasManyThrough(Exam::class, Assignment::class, 'item_id', 'id');//, 'item_id', 'id', 'id');
//
//        return $this->belongsToMany('App\Exam', 'question_assignments')->withPivot('question_number')->withTimestamps();
    }

    /**
     *
     * @return \Illuminate\Support\Collection
     */
    public function getExams()
    {
        $exams = [];
        foreach ( $this->assignments as $assignment ) {
            $exams[] = $assignment->exam;
        }
        return collect($exams);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function kumis()
    {
        return $this->hasManyThrough(Kumi::class, Exam::class);
    }


    public function notes()
    {
        return $this->belongsToMany(Note::class, 'item_note')->withTimestamps();
    }

    /**
     * Returns associated scores
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function scores()
    {
        return $this->hasMany(ItemScore::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'item_tag')->withTimestamps();
    }

    /**
     * Returns associated user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }



    /* ----------------------------------- Defaults ----------------- */
    /**
     * @return string
     */
    protected static function makeDefaultExamName(): string
    {
        return '';
//        return 'Unnamed -- created: ' . Carbon::now()->toDayDateTimeString();
    }

    /**
     * @return string
     */
    protected static function makeDefaultQuestionName(): string
    {
        return '';
//        return 'Unnamed -- created: ' . Carbon::now()->toDayDateTimeString();
    }

}

//
//    /**
//     * @deprecated So hard. Stop now.
//     * Updates an existing item or creates a new one
//     * if none exists from a request object.
//     *
//     * @param Request $request
//     * @return Item
//     */
//    static function loadItemFromRequest( Request $request )
//    {
//
//        //these are the properties of the new exam
//        //which have matches in the old models
//        //TODO create storage for all these properties
//        $examEditable = ['id', 'name'];
//        //not editable: text, number, comments
//
//        $id = $request->has('id') ? $request->input('id') : null;
//
//        switch ( self::determineItemType($request) ) {
//
//            case Exam::class:
//                $item = Exam::firstOrCreate(['id' => $id]);
//                $item->term = $request->has('term') ? $request->input('term') : Carbon::now()->year;
//                $item->year = $request->has('year') ? $request->input('year') : Carbon::now()->year;
//                $item->name = $request->has('name') ? $request->input('name') : self::makeDefaultExamName();
//                break;
//
//            case Element::class:
//                $item = Element::firstOrCreate(['id' => $id]);
//                $item->elementName = $request->has('name') ? $request->input('name') : self::makeDefaultQuestionName();
//                $item->displayText = $request->has('text') ? $request->input('text') : '';
//
//                $item->max_score = $request->has('maxScore') ? $request->input('maxScore') : '';
////                $name = $request->has('name') ? $request->input('name') : 'Unnamed -- created: ' . Carbon::now()->toDayDateTimeString();
////                $d = ['id'=> $id, 'elementName' => $name];
////                $item = Element::updateOrCreate($d);
//                break;
//
//            case Question::class:
//                $item = Question::firstOrCreate(['id' => $id]);
//                $item->questionName = $request->has('name') ? $request->input('name') : self::makeDefaultQuestionName();
//                $item->questionText = $request->has('text') ? $request->input('text') : '';
//                $item->max_score = $request->has('maxScore') ? $request->input('maxScore') : '';
//                break;
//
//            default:
//        }
//        if(isset($item)){
//            $item->save();
//
//            return $item;
//        }
//
//
//    }
//
//
//    /**
//     * @deprecated
//     * Sets the $type value from the request
//     * @param ItemRequest $request
//     */
//    static function determineItemType( Request $request )
//    {
//        if ( $request->has('idx') ) {
//            //newest version
//            //check the new style index (idx) first
//            $idx = $request->has('idx') ? $request->input('idx') : false;
//
//            if ( count($idx) > 1 ) return Element::class;
//
//            if ( $idx[0] === 0 ) return Exam::class;
//
//            if ( $idx[0] >= 1 ) return Question::class;
//
//
//        } elseif ( $request->has('depth') ) {
//            //The request will be coming in with potentially a few
//            //of the item fields filled in. However, we are only concerned with
//            //figuring out what kind of item is being requested and its relationships,
//            //and then creating those and returning the relevant ids so that
//            //they can be set on the client
//            if ( $request->input('index') === 0 ) return Exam::class;
//            if ( $request->input('depth' > 0) ) return Element::class;
//            if ( $request->input('index') >= 1 ) return Question::class;
//
//        }
//
//    }
//


//}


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
