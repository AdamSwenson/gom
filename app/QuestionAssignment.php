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

//    /**
//     * Associates with user
//     * @param $user_id
//     */
//    public function setUser($user_id)
//    {
//        $this->attributes['user_id'] = $user_id;
//    }

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

    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments', 'exam_id');
    }

    public function question()
    {
        return $this->belongsToMany('App\Question', 'question_assignments', 'question_id');
    }

    public function questionScores()
    {
        return $this->hasMany('App\QuestionScore');
    }

}
