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
        parent::boot();
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    /**
     * The user whom this belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
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
     * The question this is a score for
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    /**
     * The student whose score this is.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    /**
     * Handle legacy and aliased method calls.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $parameters)
    {
        switch ($method)
        {
            case 'setQuestionscore':
                $this->setScore($parameters);
                break;
            default:
                throw new \Exception('Bad method call');
        }
    }


}
