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
 * @property integer $id
 * @property integer $exam_id
 * @property integer $question_id
 * @property integer $element_id
 * @property integer $subtask
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\Exam $exam
 * @property-read \App\Element $element
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ElementScore[] $elementScores
 * @property-read \App\Question $question
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment whereExamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment whereElementId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment whereSubtask($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ElementAssignment onExam($examId)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModelNoUser loggedIn()
 * @mixin \Eloquent
 */
class ElementAssignment extends BaseModelNoUser
{

    protected $fillable = [
        'element_id', 'subtask'
    ];

    protected $casts = [
        'subtask' => 'integer'
    ];

    /* ------------------------------- Getters and setters ------------------------ */
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


    /**
     * Link to the exam which partially comprises the assignment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    /**
     * Link to the element which partially comprises the assignment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function element()
    {
        return $this->belongsTo('App\Element');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementScores()
    {
        return $this->hasMany('App\ElementScore');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
//        return $this->belongsTo('App\Question', 'question_assignments');
    }


}
