<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementScore extends Model
{
    protected $fillable =[];

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
        $this->attributes['elementScore'] = $score;
    }

#---- foreign keys

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function elementAssignment()
    {
        return $this->belongsTo('App\ElementAssignment');
    }
}
