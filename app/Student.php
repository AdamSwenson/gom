<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['sid', 'studentName', 'email'];


    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

#-------- foreign keys

    /**
     * Junction for classes (kumi)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kumi()
    {
        return $this->belongsToMany('App\Kumi', 'kumi_student');
    }

    /**
     * Junction with user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
