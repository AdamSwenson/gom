<?php

namespace App;

/**
 * Class ElementAssignment
 *
 * This holds an exam, an element, a questionAssignment (which maps a question to
 * a questionNumber on the exam), and a subtask (which determines the order of
 * elements for the question).
 *
 * The corresponding table ('element_assignments') has the following fields, and so this has the following attributes
 *
 * id: integer
 * exam_id: integer
 * question_id: integer
 * element_id: integer
 * subtask: integer
 *
 * @package App
 */
class ElementAssignment extends BaseModelNoUser
{

    protected $fillable = [
        'element_id', 'subtask'
    ];

    protected $casts = [
        'subtask' => 'integer'
    ];

//    public function __construct()
//    {
////        parent::junctionBoot();
////        parent::boot();
//    }

    /**
     * Returns the id of the element which this object associates with a question.
     *
     * NB, This is not the id of the present object.
     *
     * @return mixed
     */
    public function getElementId()
    {
        return $this->attributes['element_id'];
    }

    /**
     * Returns the id of the present object.
     *
     * NB, This is not the id of the element model which this object associates with a question
     * @return int
     */
    public function getElementAssignmentId()
    {
        return $this->getId();
    }

    /**
     * Returns the name of the element associated with the question
     * @return string
     */
    public function getElementName()
    {
        return $this->element->getElementName();
    }

    public function setSubtask($subtask)
    {
        $this->attributes['subtask'] = $subtask;
    }

    public function getSubtask()
    {
        return $this->attributes['subtask'];
    }

    /**
     * Return the number of the question that this element assignment belongs to
     * @return mixed
     */
    public function getQuestionNumber()
    {
        $qa = QuestionAssignment::where('exam_id', $this->attributes['exam_id'])
            ->where('question_id', $this->attributes['question_id'])
            ->first();
        return $qa->question_number;

        //return $this->questionAssignment->question_number;
    }
#--------------- Queries

    /**
     * Does not work. Needs join
     * TODO Fix on exam for elementAssignment
     * @param $query
     * @param $examId
     * @return mixed
     */
    public function scopeOnExam($query, $examId)
    {
        return $query->whereExamId($examId);
    }

//    /**
//     * Does not work. Needs join.
//     * TODO: Fix on questionNumber for elementAssignment
//     * @param $query
//     * @param $questionNumber
//     * @return mixed
//     */
//    public function scopeQuestionNumber($query, $questionNumber)
//    {
//        return $query->whereQuestionNumber($questionNumber);
//    }

# -------------- Foreign key associations
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Link to the exam which partially comprises the assignment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exam()
    {
        return $this->belongsTo('App\Exam');
//        return $this->hasManyThrough('App\Exam', 'App\QuestionAssignment', 'exam_id', 'question_assignment_id' );
    }

    /**
     * Link to the element which partially comprises the assignment
     */
    public function element()
    {
        return $this->belongsTo('App\Element');
    }

    public function elementScores()
    {
        return $this->hasMany('App\ElementScore');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
//        return $this->belongsTo('App\Question', 'question_assignments');
    }


}
