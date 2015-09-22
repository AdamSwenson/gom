<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This is a representation of the criterion for assigning a single
 * grade on an exam
 *
 * It has the attributes:
 *  exam_id: integer
 *  user_id: integer
 *  min_score: float The cut off for applying the grade
 *  grade: App\Grade The representation of the grade
 * @package App
 */
class GradeAssignment extends BaseModel
{

    /** @var array Fields that are mass assignable */
    protected $fillable = [
    ];

    protected $casts = [
        'min_score' => 'float'
    ];

    /**
     * Sets the lower bound for the grade assignment.
     * Any student with a score greater than this value (where there is no other
     * gradeAssignment with a higher value) will receive the associated grade.
     *
     * @param $minScore
     */
    public function setMinScore($minScore)
    {
        $this->attributes['min_score'] = $minScore;
    }

    /**
     * Retrieves the lower bound for the grade assignment
     * @param $minScore
     * @return mixed
     */
    public function getMinScore($minScore)
    {
        return $this->attributes['min_score'];
    }


    public function __construct()
    {
        parent::boot();
    }

    /* -------------------------------- Relationships ---------------------------------- */
    /**
     * Junction to the grade object
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grade()
    {
       return $this->hasOne('App\Grade');
    }

    /**
     * Junction to the exam object
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    /**
     * The user the grade assignment belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }



    }
