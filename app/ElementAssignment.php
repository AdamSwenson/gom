<?php

namespace App;

/**
 * Class ElementAssignment
 *
 * This holds an exam, an element, a questionAssignment (which maps a question to
 * a questionNumber on the exam), and a subtask (which determines the order of
 * elements for the question).
 *
 * The corresponding table ('element_assignments') has the following fields
 *
 * id: integer
 * user_id: integer
 * question_assignment_id: integer
 * element_id: integer
 * subtask: integer
 *
 * @package App
 */
class ElementAssignment extends BaseModel
{

    protected $fillable = [];

    protected $casts = [
        'subtask' => 'integer'
    ];

    public function __construct()
    {
//        parent::junctionBoot();
//        parent::boot();
    }

    public function setSubtask($subtask)
    {
        $this->attributes['subtask'] = $subtask;
    }

    public function getSubtask()
    {
        return $this->attributes['subtask'];
    }

    public function getQuestionNumber()
    {
        return $this->questionAssignment->question_number;
    }
#--------------- Queries

    /**
     * Does not work. Needs join
     * TODO Fix on exam for elementAssignment
     * @param $query
     * @param $examId
     * @return mixed
     */
    public function scopeOnExam($query, $examId)
    {
        return $query->whereExamId($examId);
    }

    /**
     * Does not work. Needs join.
     * TODO: Fix on questionNumber for elementAssignment
     * @param $query
     * @param $questionNumber
     * @return mixed
     */
    public function scopeQuestionNumber($query, $questionNumber)
    {
        return $query->whereQuestionNumber($questionNumber);
    }

# -------------- Foreign key associations
    public function user()
    {
        return $this->belongsTo('App\User');
    }

//    /**
//     * Get comments associated with element
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function comments()
//    {
//        return $this->hasManyThrough('App\Comment', 'App\Element');
//    }

    /**
     * Link to the exam which partially comprises the assignment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exam()
    {
        return $this->hasManyThrough('App\Exam', 'App\QuestionAssignment', 'exam_id', 'question_assignment_id' );
    }

    /**
     * Link to the element which partially comprises the assignment
     */
    public function element()
    {
        return $this->belongsTo('App\Element');
    }

    public function elementScores()
    {
        return $this->hasMany('App\ElementScore');
    }

//    public function question()
//    {
//        return $this->belongsTo('App\Question', 'question_assignments');
//    }

    public function questionAssignment()
    {
        return $this->belongsTo('App\QuestionAssignment');
    }

}
