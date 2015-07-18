<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionScore extends Model
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

    /**
     * @param $score
     */
    public function setQuestionscore($score)
    {
        $this->attributes['score'] = $score;
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function questionAssignment()
    {
        return $this->belongsTo('App\QuestionAssignment');
    }
}
