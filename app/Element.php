<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Element extends BaseModel
{
    /** Maximum length in utf-8 characters of the elementName field (used in sanitizing) */
    const MAX_NAME_LENGTH = 200;

    /** Maximum length in utf-8 characters of the displayText field (used in sanitizing) */
    const MAX_DISPLAY_LENGTH = 200;

    /** Maximum length in utf-8 characters of the commentText field (used in sanitizing) */
    const MAX_COMMENT_LENGTH = 3000;


    protected $fillable = [
        'element_id',
        'elementName',
        'displayText',
        'commentText'
    ];

    protected $casts = [
        'element_id' => 'integer',
        'elementName' => 'string',
        'displayText' => 'string',
        'commentText' => 'string'
    ];

# -------------- getters and setters

    /**
     * Records the element as a subtask of an assigned question.
     *
     *
     * @param $examId
     * @param $questionId
     * @param $subtask
     * @return $this
     */
    public function setAsQuestionTask($examId, $questionId, $subtask)
    {
        /*
        Check to see if the element is already assigned on the exam.
        If so, remove it so that there will only be one of an element per exam.
        */
//        $preExisting = ElementAssignment::where('exam_id', $examId)->where('element_id', $this->attributes['id'])->first();
//        if(! is_null($preExisting)) $preExisting->delete();

        /*
        Check to see if another element is assigned here
        If it is, delete the existing assignment.
        */
//        $e = ElementAssignment::where('exam_id', $examId)->where('question_id', $questionId)->where('subtask', $subtask)->first();
//        if(! is_null($e)) $e->delete();

        //Create a new element assignment object and populate it with the new assignment
        $newAssign = new ElementAssignment();
        $newAssign->question_id = $questionId;
        $newAssign->exam_id = $examId;
        $newAssign->subtask = $subtask;
        $newAssign->element_id = $this->attributes['id'];
        //Save it
        $newAssign->save();

        return $this;
    }


    /**
     * Sets the name of the element
     * @param string $elementName
     */
    public function setElementName($elementName)
    {
        $this->attributes['elementName'] = $elementName;
    }

    /**
     * Sets the text to be displayed while grade
     * @param string $displayText
     */
    public function setDisplayText($displayText)
    {
        $this->attributes['displayText'] = $displayText;
    }

    /**
     * Sets the base comment text
     * @param string $commentText
     */
    public function setCommentText($commentText)
    {
        $this->attributes['commentText'] = $commentText;
    }

    /**
     * Gets the name of the element
     * @return string
     */
    public function getElementName()
    {
        return $this->attributes['elementName'];
    }

    /**
     * Gets the text to be displayed while grade
     * @return string
     */
    public function getDisplayText()
    {
        return $this->attributes['displayText'];
    }

    /**
     * Gets the base comment text
     * @return string
     */
    public function getCommentText()
    {
        return $this->attributes['commentText'];
    }

#----------------- foreign keys
    /**
     * Junction to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Junction element assignment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function elementAssignments()
    {
        return $this->questionAssignments();
    }

    /**
     * Junction to questions
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Question', 'element_assignments')->withPivot('exam_id', 'subtask')->withTimestamps();
    }

    /**
     * Junction to exams
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exams()
    {
        return $this->belongsToMany('App\Exam', 'element_assignments')->withPivot('question_id', 'subtask')->withTimestamps();
    }

    /**
     * Junction to element scores
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function scores()
    {
        return $this->hasManyThrough('App\ElementScore', 'App\ElementAssignment', 'element_id',
                                     'element_assignment_id');
    }

    /**
     * Junction to comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

}
