<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'questionText',
        'questionName'
    ];

    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function setQuestiontext($questionText)
    {
        $this->attributes['questionText'] = $questionText;
    }

    public function setQuestionname($questionName)
    {
        $this->attributes['questionName'] = $questionName;
    }

    #------------ foreign keys
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function questionAssignments()
    {
        return $this->hasMany('App\QuestionAssignment');
    }

    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments');
    }
}
