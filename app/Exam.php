<?php

namespace App;

use App\Models\NewGom\ItemScore;
use App\Models\NewGom\Note;
use App\Models\NewGom\Tag;
use Illuminate\Support\Facades\DB;

/**
 * 'term' => 'string',
 * 'name' => 'string',
 * 'year' => 'year',
 * 'locked' (boolean): The exam should no longer be editable (TODO not implemented; may not want anymore)
 * 'released' (boolean): Whether the exam is currently available to students
 * previously_released (boolean): Whether the exam was ever available to students. This matters because we may want to
 * send a different email which informs them that their previous access code is invalid.
 *
 * @package App
 * @property integer $id
 * @property integer $user_id
 * @property string $term
 * @property integer $year
 * @property string $name
 * @property boolean $locked
 * @property boolean $released
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $previously_released
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Kumi[] $classes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Element[] $elementAssignments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Element[] $elements
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questionAssignments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuestionScore[] $questionScores
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereTerm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereLocked($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereReleased($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam wherePreviouslyReleased($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam onClasses($kumiId)
 * @method static \Illuminate\Database\Query\Builder|\App\Exam unlocked()
 * @method static \Illuminate\Database\Query\Builder|\App\Exam unreleased()
 * @method static \Illuminate\Database\Query\Builder|\App\Exam released()
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel loggedIn()
 * @mixin \Eloquent
 */
class Exam extends BaseModel
{
    /** Maximum length in utf-8 characters of the term field (used in sanitizing) */
    const MAX_TERM_LENGTH = 100;
    const MIN_TERM_LENGTH = 2;

    /** Maximum length in utf-8 characters of the name field (used in sanitizing) */
    const MAX_NAME_LENGTH = 100;
    const MIN_NAME_LENGTH = 2;

    /** Maximum length in digits of the year field (used in sanitizing) */
    const MAX_YEAR_LENGTH = 4;

    protected $guarded = ['user_id', 'id'];

    public $index = 0;

//    protected $fillable = [
//        'term',
//        'name',
//        'year',
//        'released',
//        'previously_released',
//    ];

    protected $casts = [
        'locked' => 'boolean',
        'name' => 'string',
        'public_name' => 'string',
        'previously_released' => 'boolean',
        'released' => 'boolean',
        'term' => 'string',
        'other' => 'array',
        'year' => 'year',
    ];


#----------------------------------------------------------- Item ordering

    /**
     * Adds an Item to the exam either with the exam itself
     * or another item as the parent.
     * @param Item $item
     * @param $parentId
     * @param $depth
     */
    public function addAssignment( Item $item, $parentId, $depth )
    {
        //we need the assignment id of the parent
        //to link them, so get the parent assignment
        //This is okay as long as we can presume that
        //if we haven't processed the parent yet.
        // it will be updated when we get to it.
        $parentAssign = Assignment::firstOrCreate(
            [
                'exam_id' => $this->id,
                'item_id' => $parentId
            ]);

        //Now we can make the actual assignment entry
        $assignment = Assignment::firstOrCreate([
            'exam_id' => $this->id,
            'item_id' => $item->id,
        ]);

        //and finally associate it into the tree.
        $parentAssign->addChild($assignment, $depth);
    }

    /**
     * Returns the Assignment representing the exam
     */
    public function getAssignmentRoot()
    {
        return Assignment::where('exam_id', $this->id)
            ->where('parent_id', null)
            ->where('item_id', $this->id)
            ->first();
    }

    /**
     * Creates an assignment in the assignments table
     * with this exam's id as item_id and exam_id
     * @return bool
     */
    public function initializeAssignmentRoot()
    {
        if ( $this->getAssignmentRoot() ) return true;
        $assignment = Assignment::create([
            'item_id' => $this->id,
            'exam_id' => $this->id
        ]);

        $this->assignments()->save($assignment);
    }

    /**
     * If was associated with assignments, deletes the association
     * and creates a new assignment
     * If was none preexisting, creates new
     */
    public function resetAssignments()
    {
        //delete all items from assignment table with this
        //exam id
        Assignment::where('exam_id', $this->id)->delete();
        //create a new assignment
        $this->initializeAssignmentRoot();
    }


# -------------------------- Helpful methods

    /**
     * Marks the exam as released.
     * Also sets the previously_released to true
     */
    public function releaseExam()
    {
        $this->attributes['released'] = true;
        $this->attributes['previously_released'] = true;
        $this->save();

        return true;
    }

    /**
     * Removes the released status.
     * Does not affect the previously_released value
     */
    public function hideExam()
    {
        $this->attributes['released'] = false;
        $this->save();

        return true;
    }

    /**
     * Returns true if the exam is currently released; false otherwise
     * @return bool
     */
    public function isReleased()
    {
        if ( !empty($this->attributes['released']) && $this->attributes['released'] == true ) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if at least one question for at least one student
     * has been graded. Returns false otherwise.
     * @return bool
     */
    public function isGraded()
    {
        $query = <<<MYSQL
        SELECT count(qs.score) AS numberGraded FROM question_scores qs
        INNER JOIN question_assignments qa ON qa.id = qs.question_assignment_id
        WHERE qa.exam_id = :examId;
MYSQL;
        $result = DB::select($query, ['examId' => $this->attributes['id']]);
        if ( $result[0]->numberGraded > 0 ) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the exam has ever been released
     * @return bool
     */
    public function wasPreviouslyReleased()
    {
        if ( !empty($this->attributes['previously_released']) && $this->attributes['previously_released'] == true ) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if there is at least one question and one student
     * associated with the exam.
     */
    public function isGradable()
    {

        $questions = $this->questions;

        if ( !empty($questions) && count($questions) > 0 ) {
            $students = $this->getAllAssociatedStudents();
            if ( !empty($students) && count($students) > 0 ) {
                return true;
            }

        }

        return false;
    }

    /**
     * Returns the kumi which is marked as roster.
     * That is the kumi which all students associated with the exam
     * share.
     */
    public function roster()
    {
        return $this->kumis()->where('is_roster', true)->first();
    }

#------------------------------------------------------- Queries

    /**
     * Limits the query to the specified class/kumi
     * @param $query
     * @param $kumiId
     * @return mixed
     */
    public function scopeOnClasses( $query, $kumiId )
    {
        return $query->where('kumi_id = ?', $kumiId);
    }

    /**
     * Limits the query to unlocked exams
     * @param $query
     * @return mixed
     */
    public function scopeUnlocked( $query )
    {
        return $query->whereLocked(0);
    }

    /**
     * Limits the query to exams which are not currently released
     * @param $query
     * @return mixed
     */
    public function scopeUnreleased( $query )
    {
        return $query->whereReleased(0);
    }

    /**
     * Limits the query to exams which are currently released
     * @param $query
     * @return mixed
     */
    public function scopeReleased( $query )
    {
        return $query->whereReleased(1);
    }
    # ----------------------------------- Setters

    /**
     * Set the term in which the exam occurs
     * @param string $term
     * @return $this|void
     */
    public function setTerm( $term )
    {
        $this->attributes['term'] = $term;
    }

    /**
     * Set exam name
     * @param string $name
     * @return $this The current object (for fluent API support)
     */
    public function setName( $name )
    {
        $this->attributes['name'] = $name;
    }

    /**
     * Set the year of the exam
     * @param int|string $year
     * @return $this|\Exam|void
     */
    public function setYear( $year )
    {
        $this->attributes['year'] = $year;
    }

    /**
     * Set the value of [locked] column.
     *
     * @param $value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setLocked( $value )
    {
        $this->attributes['locked'] = $value;
    }

    /**
     * Set the value of [released] column.
     *
     * @param $value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setReleased( $value )
    {
        $this->attributes['released'] = $value;
    }

//    public function getQuestion($questionNumber)
//    {
//     //   return $this->questions->pivot->wherePivot('question_number', $questionNumber)->first();
//    }


    # --------------------------------- Getters

    /**
     * Returns a collection of all students who have been associated with the exam
     * The collection is sorted in descending order by last_name
     * @return \Illuminate\Support\Collection
     */
    public function getAllAssociatedStudents()
    {
        $students = [];
        $classes = $this->classes;
        foreach ( $classes as $c ) {
            foreach ( $c->students as $s ) {
                $students[] = $s;
            }
        }

        //Make into a laravel collection and sort in descending order
        $students = collect($students);
        $students = $students->sortBy('last_name');

        return $students;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * Returns all the associated item objects
     * in no order
     * @return array
     */
    public function getItems()
    {
        $out = [];
        $assignmentTree = $this->getAssignmentRoot();
// Assignment::where('item_id', $this->id)
//            ->where('exam_id', $this->id)
//            ->get();
        if ( $assignmentTree->hasChildren() ) {
            $children = $assignmentTree->getChildren();
            //children now holds a bunch of Assignment objects
            foreach ( $children as $c ) {
                //push Item objects into the out array
                $out[] = $c->item;
            }
        }
        return $out;
    }

    /**
     * Get the term column value
     * @return string
     */
    public function getTerm()
    {
        return $this->attributes['term'];
    }

    /**
     * Get the name column value
     * @return string
     */
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * Get the [locked] column value.
     *
     * @return int
     */
    public function getLocked()
    {
        return $this->attributes['locked'];
    }

    /**
     * Returns the maximum possible achievable score on the exam.
     * If there is a custom max set, it will return that.
     * Otherwise, it returns the sum of max scores for all items
     * which count toward the total exam score.
     * @return array|mixed
     */
    public function getMaxPossibleScore()
    {
        if(! is_null($this->custom_max_score)){
            return $this->custom_max_score;
        }

        $query = <<<MYSQL
            SELECT  SUM(i.max_score) as maxScore FROM assignments a
            INNER JOIN items i ON i.id = a.item_id
            WHERE a.exam_id = :examId AND i.counts_in_total = 1
MYSQL;
        $result = DB::select($query, ['examId' => $this->attributes['id']]);
        return $result[0]->maxScore;
    }

    public function getMaxPossibleScoreAttribute()
    {
        $items = collect($this->getItems());
        return $items->sum('max_score');
    }

    /**
     * Get the [released] column value.
     *
     * @return int
     */
    public function getReleased()
    {
        return $this->attributes['released'];
    }

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user->id;
    }

    /**
     * Get the name column value
     * @return string
     */
    public function getYear()
    {
        return $this->attributes['year'];
    }


    #------------------------------------------------------ foreign keys

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assignment()
    {
        return $this->getAssignmentRoot();
        //hasOne(Assignment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Classes (kumis) taking the exam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classes()
    {
        return $this->belongsToMany('App\Kumi', 'exam_kumi')->withTimestamps();
    }

    /**
     * Associated elements and their subtask numbers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementAssignments()
    {
        return $this->belongsToMany('App\Element', 'element_assignments')
            ->withPivot('subtask')
            ->withTimestamps();
    }

    /**
     * Elements comprising the exam
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->belongsToMany('App\Element', 'element_assignments')->withPivot('subtask')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gradingTimes()
    {
        return $this->hasMany(GradingTime::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gradeAssignments()
    {
        return $this->hasMany(GradeAssignment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function items()
    {
        return $this->hasManyThrough(Item::class, Assignment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemScores()
    {
        return $this->hasMany(ItemScore::class);
    }

    /**
     * Classes (kumis) taking the exam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kumis()
    {
        return $this->belongsToMany('App\Kumi', 'exam_kumi')->withTimestamps();
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class, 'exam_note')->withTimestamps();
    }

    /**
     * Junction to all questions associated with the exam
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function questions()
    {
        return $this->belongsToMany('App\Question', 'question_assignments')->withPivot('question_number')->withTimestamps();


        /*The third argument is the name of the foreign key on the intermediate model,
        the fourth argument is the name of the foreign key on the final model, and 
        the fifth argument is the local key:*/

        /*return $this->hasManyThrough('App\Question', 'App\QuestionAssignment', 'a', 'b', 'c');
         * select `questions`.*, `question_assignments`.`a`
         * from `questions` inner join `question_assignments` on `question_assignments`.`id` = `questions`.`b`
         * where `question_assignments`.`a` is null and `user_id` = 1)
        */

//        return $this->hasManyThrough('App\Question', 'App\QuestionAssignment', 'exam_id', 'id', 'question_id');
//        return $this->hasManyThrough('App\Question', 'App\QuestionAssignment', 'exam_id', 'id', 'question_id');
    }

    /**
     * Junction to assignments of questions to the exam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questionAssignments()
    {
        return $this->belongsToMany('App\Question', 'question_assignments')->withPivot('question_number')->withTimestamps();
    }

    /**
     * Junction to assignments of question scores
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function questionScores()
    {
        return $this->hasManyThrough('App\QuestionScore', 'App\QuestionAssignment');
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, Kumi::class); //, 'exam_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'exam_tag')->withTimestamps();
    }

    /**
     * Associated user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


}

