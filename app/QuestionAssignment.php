<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAssignment extends Model
{

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
        return $this->belongsToMany('App\Exam', 'question_assignments');
    }

    public function questionScores()
    {
        return $this->hasMany('App\QuestionScore');
    }
}
