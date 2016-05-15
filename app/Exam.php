<?php

namespace App;

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


    protected $fillable = [
        'term',
        'name',
        'year',
        'released',
        'previously_released'
    ];

    protected $casts = [
        'term'     => 'string',
        'name'     => 'string',
        'year'     => 'year',
        'locked'   => 'boolean',
        'released' => 'boolean',
        'previously_released' => 'boolean',
    ];

    public function __construct()
    {
        parent::boot();
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
        if ( ! empty($this->attributes['released']) && $this->attributes['released'] == true )
        {
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
        if ( $result[0]->numberGraded > 0 )
        {
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
        if ( ! empty($this->attributes['previously_released']) && $this->attributes['previously_released'] == true )
        {
            return true;
        }

        return false;
    }


    /**
     * Returns a collection of all students who have been associated with the exam
     * @return \Illuminate\Support\Collection
     */
    public function getAllAssociatedStudents()
    {
        $students = [];
        $classes = $this->classes;
        foreach ( $classes as $c )
        {
            foreach ( $c->students as $s )
            {
                $students[] = $s;
            }
        }

        //Make into a laravel collection and sort in descending order
        $students = collect($students);
        $students = $students->sortBy('last_name');

        return $students;
    }







#------------------------------------------------------- Queries

    /**
     * Limits the query to the specified class/kumi
     * @param $query
     * @param $kumiId
     * @return mixed
     */
    public function scopeOnClasses($query, $kumiId)
    {
        return $query->where('kumi_id = ?', $kumiId);
    }

    /**
     * Limits the query to unlocked exams
     * @param $query
     * @return mixed
     */
    public function scopeUnlocked($query)
    {
        return $query->whereLocked(0);
    }

    /**
     * Limits the query to exams which are not currently released
     * @param $query
     * @return mixed
     */
    public function scopeUnreleased($query)
    {
        return $query->whereReleased(0);
    }

    /**
     * Limits the query to exams which are currently released
     * @param $query
     * @return mixed
     */
    public function scopeReleased($query)
    {
        return $query->whereReleased(1);
    }

#----------------------------------------------------------- Setters and getters

    /**
     * Set the term in which the exam occurs
     * @param string $term
     * @return $this|void
     */
    public function setTerm($term)
    {
        $this->attributes['term'] = $term;
    }

    /**
     * Set exam name
     * @param string $name
     * @return $this The current object (for fluent API support)
     */
    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }

    /**
     * Set the year of the exam
     * @param int|string $year
     * @return $this|\Exam|void
     */
    public function setYear($year)
    {
        $this->attributes['year'] = $year;
    }

//    public function getQuestion($questionNumber)
//    {
//     //   return $this->questions->pivot->wherePivot('question_number', $questionNumber)->first();
//    }


    #------------------------------------------------------ foreign keys

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
        return $this->belongsToMany('App\Element', 'element_assignments')->withPivot('subtask')->withTimestamps();
        //'App\QuestionAssignment');
    }

    /**
     * Elements comprising the exam
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->belongsToMany('App\Element', 'element_assignments')->withPivot('subtask')->withTimestamps();
//        return $this->hasMany('App\Element');
    }

//    /**
//     * Associated element scores
//     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
//     */
//    public function elementScores()
//    {
//        return $this->hasManyThrough('App\ElementScore', 'App\ElementAssignment');
//    }

    /**
     * Junction to all questions associated with the exam
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function questions()
    {
        return $this->hasManyThrough('App\Question', 'App\QuestionAssignment');
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

    /**
     * Associated user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    # --------------------------------- Other getters and setters

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
        // TODO: Implement getUserId() method.
    }

    /**
     * Get the name column value
     * @return string
     */
    public function getYear()
    {
        return $this->attributes['year'];
    }

    /**
     * Set the value of [locked] column.
     *
     * @param $value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setLocked($value)
    {
        $this->attributes['locked'] = $value;
    }

    /**
     * Set the value of [released] column.
     *
     * @param $value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setReleased($value)
    {
        $this->attributes['released'] = $value;
    }

//    //Here active use - BaseModel
//    public static function boot()
//    {
//        parent::boot();
//    }

}

