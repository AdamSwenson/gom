<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Kumi
 * Japanese for 'class' as in 'I want this exam to be associated with three classes'.
 * Because if you go around calling something 'class', bad things can happen.
 * @package App
 */
class Kumi extends Model
{
    protected $fillable = [
        'nickname',
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

#--------- Foreign keys
    public function student()
    {
        return $this->belongsToMany('App\Kumi', 'kumi_student');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exams()
    {
        return $this->belongsToMany('App\Exam', 'exam_kumi');
    }


}
