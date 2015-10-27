<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['access_key', 'content'];

    protected $casts = [
        'content' => 'array'
    ];

    protected $table = 'feedback';

    protected $primaryKey = 'access_key';

    protected $questionNumbers = [];

    /**
     * Returns the string encoded array of comments.
     * NB., if you just do $this->content instead, the result
     * will be an array
     * @return string
     */
    public function content()
    {
        return $this->attributes['content'];
    }

    /**
     * Getter for the string to be displayed to the student
     * @return string
     */
    public function grade()
    {
        return $this->attributes['grade_display'];
    }

    /**
     * Getter for the calculated value of the grade
     * @return float
     */
    public function gradeValue()
    {
        return $this->attributes['grade_calc'];
    }

    public function getAccessKey()
    {
        return $this->attributes['access_key'];
    }

    public function setAccessKey($accessKey)
    {
        $this->attributes['access_key'] = $accessKey;
    }


public function getQuestionNumbers()
{
  $this->populateQuestionNumbers();
    return $this->questionNumbers;
}

    protected function populateQuestionNumbers()
    {
        if( empty($this->questionNumbers) )
        {
            foreach (json_decode($this->attributes['content']) as $c)
            {
                $this->questionNumbers[] = $c->questionNumber;
            }
        }
    }

    public function scopeByAccessKey($query, $accessKey)
    {
        return $query->where('access_key', $accessKey);
    }
}
