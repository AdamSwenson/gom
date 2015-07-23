<?php

namespace App;


class ElementScore extends BaseModel
{
    protected $fillable = [];

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

    public function setElementscore($score)
    {
        $this->attributes['score'] = $score;
    }

#---- foreign keys

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function element()
    {
        return $this->belongsTo('App\Element');
    }


    public function elementAssignment()
    {
        return $this->belongsTo('App\ElementAssignment');
    }
}
