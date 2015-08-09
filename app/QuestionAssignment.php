<?php

namespace App;

class QuestionAssignment extends BaseModel
{
    protected $fillable = [];

    protected $casts = [
      'questionNumber' => 'integer'
    ];

//    public static function boot()
//    {
//        static::addGlobalScope(new \App\UserOnlyJunctionScope());
//
//        static::creating(function($model)
//        {
//            $user = \Auth::user();
//            $model->owner_id = $user->id;
//        });
//
//        static::updating(function($model)
//        {
//            $user = \Auth::user();
//            $model->owner_id = $user->id;
//        });
//
//        static::deleting(function($model){
//            $user = \Auth::user();
//            $model->owner_id = $user->id;
//        });
//    }

    public function __construct()
    {
//self::boot();
//        parent::junctionBoot();
    }

    /**
     * Returns the name of the associated question object
     * @return string
     */
    public function getQuestionName()
    {
        $obj = $this->question->first();
        return $obj->getQuestionName();
    }

    /**
     * Returns the number (i.e., the order) of the associated question on the exam
     * @return integer
     */
    public function getQuestionNumber()
    {
        return $this->attributes['question_number'];
    }

    /**
     * Returns the id of the associated question (i.e., the question which this object is associating
     * with an exam).
     *
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->attributes['question_id'];
    }

    /**
     * Returns the id of the question assignment (i.e., the association of the question with an exam).
     *
     * NB, This is not the id number of the Question model/object.
     *
     * @return int
     */
    public function getQuestionAssignmentId()
    {
        return $this->getId();
    }

    /**
     * Returns the exam id that this assignment is for
     *
     * @return int
     */
    public function getExamId()
    {
        return $this->attributes['exam_id'];
    }


#--------------- Queries
    public function scopeOnExam($query, $examId)
    {
        return $query->whereExamId($examId);
    }

    public function scopeOnQuestionId($query, $questionId)
    {
        return $query->whereQuestionId($questionId);
    }

    public function scopeQuestionNumber($query, $questionNumber)
    {
        return $query->whereQuestionNumber($questionNumber);
    }

# -------------- Foreign key associations
//    public function user()
//    {
//        return $this->belongsTo('App\User', 'owner_id', 'id');
//    }

    /**
     * Elements associated with this question
     */
    public function elementAssignments()
    {
        return $this->hasMany('App\ElementAssignment');
    }

    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments', 'exam_id');
    }

    public function question()
    {
//        return $this->hasOne('App\Question', 'question_assignments', 'question_id');
        return $this->belongsToMany('App\Question', 'question_assignments', 'question_id');
    }

    public function questionScores()
    {
        return $this->hasMany('App\QuestionScore');
    }

}
