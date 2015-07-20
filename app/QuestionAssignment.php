<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAssignment extends Model
{
    protected $fillable = [];

    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
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
