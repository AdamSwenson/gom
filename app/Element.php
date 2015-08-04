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

    public function __construct()
    {
        parent::boot();
    }

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
     * Records the element as a subtask of an assigned question
     * @param $examId
     * @param $questionId
     * @param $subtask
     * @return $this
     */
    public function setAsQuestionTask($examId, $questionId, $subtask)
    {
        $questionAssignment = QuestionAssignment::where('exam_id', $examId)->where('question_id', $questionId)->firstOrFail();
        $query = 'CALL assign_element(:questionAssignmentId, :subtask, :elementId)';
        $values = [
            'questionAssignmentId' => $questionAssignment->id,
            'subtask' => $subtask,
            'elementId' => $this->attributes['id']
        ];
        DB::statement($query, $values);


        //$questionAssignment = QuestionAssignment::where('exam_id', $examId)->where('question_id', $questionId)->firstOrFail();

        /*        //works with raw
                $query = "INSERT INTO element_assignments (question_assignment_id, subtask, element_id)
                VALUES (:assignId, :subtask, :elementId) ON DUPLICATE KEY UPDATE element_id = :element_id";
                $vals = [
                    'assignId' => $questionAssignment->getId(),
                    'subtask' => $subtask,
                    'elementId' => $this->attributes['id']
                ];
                DB::raw($query, $vals);*/

//        ElementAssignment::updateOrCreate(
//            ['question_assignment_id' => $questionAssignment->getId(), 'subtask' => $subtask],
//            ['element_id' => $this->attributes['id']]
//        );
//
//        $pre_existing = ElementAssignment::where('subtask', $subtask)->where('question_assignment_id',
//            $questionAssignment->getId());
//        if ($pre_existing)
//        {
//            $pre_existing->delete();
//        }
//
//
////    $pre_assigned = ElementAssignment::where('exam_id', $examId)->where('question_id', $this->getId());
////    if($pre_assigned)
////    {
////        $pre_assigned->delete();
////    }
//        $this->questionAssignments()->attach($questionAssignment->getId(), ['subtask' => $subtask]);

        return $this;
    }

    /**
     * Returns integer subtask
     * @param $questionAssignmentId
     * @return mixed
     * @internal param $examId
     * @internal param $questionId
     */
    public function getQuestionTaskNumber($questionAssignmentId)
    {
        $e = $this->questionAssignments()->where('question_assignment_id', $questionAssignmentId)->first();

        return $e->pivot->subtask;
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
     * Sets the text to be displayed while grading
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
     * Gets the text to be displayed while grading
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

    public function questionAssignments()
    {
        return $this->belongsToMany('App\QuestionAssignment',
                                    'element_assignments')->withPivot('subtask')->withTimestamps();
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

    //    public function exam()
//    {
//        return $this->belongsToMany('App\Exam', 'element_assignments');
//    }

//    public function questions()
//    {
//        return $this->hasManyThrough('App\Question', 'App\QuestionAssignment', 'element_id');//App\QuestionAssignment')->withTimestamps();
//    }

//
//    /**
//     * Handle legacy and aliased method calls.
//     *
//     * @param  string $method
//     * @param  array $parameters
//     * @return mixed
//     */
//    public function __call($method, $parameters)
//    {
//        switch($method)
//        {
//            case 'getDisplaytext':
//                $this->getDisplayText();
//                break;
//            case 'getElementname':
//                $this->getElementName();
//                break;
//            case 'getCommenttext':
//                $this->getCommentText();
//                break;
//            case 'setDisplaytext':
//                $this->setDisplayText($parameters);
//                break;
//            case 'setElementname':
//                $this->getElementName($parameters);
//                break;
//            case 'setCommenttext':
//                $this->setCommentText($parameters);
//                break;
//            default:
//                break;
//        }
//    }


}
