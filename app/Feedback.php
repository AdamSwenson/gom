<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends BaseModelNoUser
{
    const NO_GRADE = 'Not Assigned';

    protected $fillable = ['access_key', 'content'];

    protected $casts = [
        'content' => 'array'
    ];

    protected $table = 'feedback';

//    protected $primaryKey = 'access_key';

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
     * Getter for the string to be displayed to the student.
     * Returns 'Not Assigned' if no grade assigned
     * @return string
     */
    public function grade()
    {
        $r = $this->attributes['grade_display'] ? $this->attributes['grade_display'] : self::NO_GRADE;

        return $r;
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

    /**
     * Alias for access key so that if someone
     * tries to access accessKey (which was an earlier property)
     * they will still get what they expect.
     * @return array
     */
    public function getAccessKeyAttribute()
    {
        return $this->attributes['access_key'];
    }


    public function setAccessKey($accessKey)
    {
        $this->attributes['access_key'] = $accessKey;
    }


    /**
     * Returns the question numbers for which feedback has been
     * stored.
     * @return array
     */
    public function getQuestionNumbers()
    {
        $this->populateQuestionNumbers();

        return $this->questionNumbers;
    }

    /**
     * Decodes json stored question numbers and populates the
     * self::questionNumbers array.
     * Should run only once per object
     */
    protected function populateQuestionNumbers()
    {
        if (empty($this->questionNumbers))
        {
            $j = $this->content();
            $content = json_decode($j);
            foreach ($content as $c)
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
