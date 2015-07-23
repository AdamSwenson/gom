<?php

namespace App;

class QuestionAssignment extends BaseModel
{
    protected $fillable = [];

    protected $casts = [
      'questionNumber' => 'integer'
    ];

    public function __construct()
    {
        parent::boot();
    }

    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

#--------------- Queries
    public function scopeOnExam($query, $examId)
    {
        return $query->whereExamId($examId);
    }

    public function scopeQuestionNumber($query, $questionNumber)
    {
        return $query->whereQuestionNumber($questionNumber);
    }

# -------------- Foreign key associations
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam', 'question_assignments');
    }

    public function question()
    {
        return $this->hasOne('App\Question');
    }

    public function questionScores()
    {
        return $this->hasMany('App\QuestionScore');
    }
}
