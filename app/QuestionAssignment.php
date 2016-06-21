<?php

namespace App;

/**
 * Class QuestionAssignment
 * 
 * This has the following attributes:
 *      id: integer
 *      exam_id: integer        The id of the exam to which the question is assigned
 *      question_id: integer    The id of the question being assigned
 *      questionNumber: integer The number of the question on the exam (i.e., the order of the question)
 *
 * @package App
 * @property integer $id
 * @property integer $exam_id
 * @property integer $question_id
 * @property integer $question_number
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Exam[] $exam
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $question
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuestionScore[] $questionScores
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment whereExamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment whereQuestionNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment onExam($examId)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment onQuestionId($questionId)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAssignment questionNumber($questionNumber)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModelNoUser loggedIn()
 * @mixin \Eloquent
 */
class QuestionAssignment extends BaseModelNoUser
{
    protected $fillable = [
        'exam_id',
        'question_id',
        'question_number'
    ];

    protected $casts = [
      'questionNumber' => 'integer'
    ];

//    /**
//     * The constructor is necessary to override the base model global
//     * scoping since this does not have a user_id field
//     * QuestionAssignment constructor.
//     */
//    public function __construct()
//    {}

    /**
     * Returns the name of the associated question object
     * @return string
     */
    public function getQuestionName()
    {
        $qid = $this->question_id;
        $question = Question::where('id', $qid)->first();
        return $question->getQuestionName();
    }

    /**
     * Returns the question object associated with this assignment
     * @return Question
     */
    public function getQuestion()
    {
        $qid = $this->question_id;
        return Question::where('id', $qid)->first();
    }

    /**
     * Returns the number (i.e., the order) of the associated question on the exam
     * @return integer
     */
    public function getQuestionNumber()
    {
        return $this->attributes['question_number'];
    }

    /**
     * Returns the id of the associated question (i.e., the question which this object is associating
     * with an exam).
     *
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->attributes['question_id'];
    }

    /**
     * Returns the id of the question assignment (i.e., the association of the question with an exam).
     *
     * NB, This is not the id number of the Question model/object.
     *
     * @return int
     */
    public function getQuestionAssignmentId()
    {
        return $this->getId();
    }

    /**
     * Returns the exam id that this assignment is for
     *
     * @return int
     */
    public function getExamId()
    {
        return $this->attributes['exam_id'];
    }


#--------------- Queries
    public function scopeOnExam($query, $examId)
    {
        return $query->whereExamId($examId);
    }

    public function scopeOnQuestionId($query, $questionId)
    {
        return $query->whereQuestionId($questionId);
    }

    public function scopeQuestionNumber($query, $questionNumber)
    {
        return $query->whereQuestionNumber($questionNumber);
    }

# -------------- Foreign key associations
    /**
     * Elements associated with this question
     */
    public function elementAssignments()
    {
        return ElementAssignment::where('exam_id', $this->attributes['exam_id'])->where('question_id', $this->attributes['question_id'])->get();
    }

    /**
     * Junction to exam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments', 'exam_id');
    }

    /**
     * Junction to question table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function question()
    {
        return $this->belongsToMany('App\Question', 'question_assignments', 'question_id');
    }

    /**
     * Junction to question scores table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionScores()
    {
        return $this->hasMany('App\QuestionScore');
    }

}
