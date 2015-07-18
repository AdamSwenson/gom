<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $fillable = [
        'elementName',
        'displayText',
        'commentText'
    ];

# -------------- setters
    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function setElementname($elementName)
    {
        $this->attributes['elementName'] = $elementName;
    }

    public function setDisplaytext($displayText)
    {
        $this->attributes['displayText'] = $displayText;
    }

    public function setCommenttext($commentText)
    {
        $this->attributes['commentText'] = $commentText;
    }

#----------------- foreign keys
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'element_assignments');
    }
}
