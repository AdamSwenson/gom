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

    /**
     * Classes (kumis) taking the exam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classes()
    {
        return $this->belongsToMany('App\Kumi', 'exam_kumi')->withTimestamps();
    }

    /**
     * Elements comprising the exam
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function elements()
    {
        return $this->hasManyThrough('App\Element', 'App\ElementAssignment');
    }

    /**
     * Get the elements and their subtask numbers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementAssignments()
    {
        return $this->hasMany('App\ElementAssignment', 'element_assignments');
    }

    public function elementScores()
    {
        return $this->hasManyThrough('App\ElementScore', 'App\ElementAssignment');
    }

    /**
     * Get all questions associated with the exam
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function questions()
    {
        return $this->hasManyThrough('App\Question', 'App\QuestionAssignment');
    }

    public function questionAssignments()
    {
        return $this->hasMany('App\QuestionAssignment', 'question_assignments');
    }

    public function questionScores()
    {
        return $this->hasManyThrough('App\QuestionScore', 'App\QuestionAssignment');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

