<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'term',
        'topic',
        'year'
    ];

    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function setTerm($term)
    {
        $this->attributes['term'] = $term;
    }

    public function setYear($year)
    {
        $this->attributes['year'] = $year;
    }

    public function setTopic($topic)
    {
        $this->attributes['topic'] = $topic;
    }

    #--------- foreign keys

    public function classes()
    {
        return $this->belongsToMany('App\Kumi', 'exam_kumi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

