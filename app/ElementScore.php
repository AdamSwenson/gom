<?php

namespace App;


class ElementScore extends BaseModel
{
    protected $fillable = [];

    public function __construct()
    {
//        parent::junctionBoot();
    }


    /**
     * Returns results limited to the particular student
     * @param $query
     * @param $studentId
     * @return mixed
     */
    public function scopeOnStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Returns results limited to the question assignment id
     * @param $query
     * @param $elementAssignmentId
     * @return mixed
     */
    public function scopeOnElementAssignment($query, $elementAssignmentId)
    {
        return $query->whereElementAssignmentId($elementAssignmentId);
    }

    public function scopeOnStudentElementAssignment($query, $studentId, $elementAssignmentId)
    {
        return $query->where('student_id', $studentId)->where('element_assignment_id', $elementAssignmentId);
    }


    # -------------------------------- getters and setters
    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function setScore($score)
    {
        $this->attributes['score'] = $score;
    }

    /**
     * Returns the score for the element
     * @return mixed
     */
    public function getScore()
    {
        return $this->attributes['score'];
    }

#---- foreign keys

    public function user()
    {
        return $this->belongsTo('App\User');
    }

//    public function exam()
//    {
//        return $this->belongsTo('App\Exam', 'element_assignment_id');
//    }

    public function students()
    {
        return $this->belongsToMany('App\Student', 'element_scores', 'student_id', 'element_assignment_id')->withPivot('score')->withTimestamps();
    }

    public function elementAssignment()
    {
        return $this->belongsTo('App\ElementAssignment');
    }

    public function element()
    {
        return $this->belongsToMany('App\Element', 'element_assignments', 'id');
    }

//    public function question()
//    {
//        return $this->belongsTo('App\Question', 'element_assignment_id');
//    }



}
