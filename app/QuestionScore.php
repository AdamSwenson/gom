<?php

namespace App;


/**
 * Class QuestionScore
 * This associates a question assignment (which connects an exam and question)
 * with a student and holds the score that the student achieved for the question.
 *
 * @package App
 */
class QuestionScore extends BaseModel
{
    protected $fillable = [];

    protected $casts = [
        'score' => 'float'
    ];

    public function __construct()
    {
     //   parent::junctionBoot();
    }

    #--------------------------------- queries

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
     * @param $questionAssignmentId
     * @return mixed
     */
    public function scopeOnQuestionAssignment($query, $questionAssignmentId)
    {
        return $query->whereQuestionAssignmentId($questionAssignmentId);
    }

    public function scopeOnStudentAndQuestionAssignment($query, $studentId, $questionAssignmentId)
    {
        return $query->where('student_id', $studentId)->where('question_assignment_id', $questionAssignmentId);
    }

//    /**
//     * Gets all scores for a particular question on a particular exam
//     * @param $query
//     * @param $examId
//     * @param $questionNumber
//     */
//    public function scopeOnExamAndQuestionNumber($query, $examId, $questionNumber)
//    {
//
//    }


    #--------------------------------- getters and setters
    /**
     * Get the score
     * @return float
     */
    public function getScore()
    {
        return $this->attributes['score'];
    }

    /**
     * Sets the score for the question
     * @param float $score
     */
    public function setScore($score)
    {
        $this->attributes['score'] = $score;
    }

    #---------------------------------------- foreign keys
    /**
     * Exam that this questionScore is part of
     */
    public function exam()
    {
        return $this->hasManyThrough('App\Exam', 'App\QuestionAssignment', 'id', 'id');
    }


    /**
     * The question assignment object which links this score to a question and exam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionAssignment()
    {
        return $this->belongsTo('App\QuestionAssignment');
    }

    /**
     * Junction with the questions table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsToMany('App\Question', 'question_assignments', 'id');
    }

    /**
     * Junction with the students table .
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsToMany('App\Student', 'question_scores', 'student_id', 'question_assignment_id')->withPivot('score')->withTimestamps();
//        return $this->belongsTo('App\Student');
    }


    //    /**
//     * The user whom this belongs to
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function user()
//    {
//        return $this->belongsTo('App\User');
//    }

//    /**
//     * Handle legacy and aliased method calls.
//     *
//     * @param  string $method
//     * @param  array $parameters
//     * @return mixed
//     * @throws \Exception
//     */
//    public function __call($method, $parameters)
//    {
//        switch ($method)
//        {
//            case 'setQuestionscore':
//                $this->setScore($parameters);
//                break;
//            default:
//                throw new \Exception('Bad method call');
//        }
//    }


}
