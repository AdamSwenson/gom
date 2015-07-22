<?php

namespace App;


class ElementAssignment extends BaseModel
{

    public function createAssignment(\App\Exam $exam, \App\Question $question, \App\Element $element, $score )
    {}


    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

#--------- Foreign keys
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'element_assignments');
    }

    public function elementScores()
    {
        return $this->hasMany('App\ElementScore');
    }
}
